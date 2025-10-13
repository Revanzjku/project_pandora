<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ebook;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class KelolaEbook extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $sort = 'latest';
    public $perPage = 30;

    public $showDeleteModal = false;
    public $ebookToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'sort' => ['except' => 'latest']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function confirmDelete($ebookId)
    {
        $ebook = Ebook::findOrFail($ebookId);
        $this->ebookToDelete = $ebook;
        $this->showDeleteModal = true;
    }

    public function deleteEbook()
    {
        if ($this->ebookToDelete) {
            // Hapus file cover jika ada
            if ($this->ebookToDelete->cover_image_path) {
                Storage::delete('public/' . $this->ebookToDelete->cover_image_path);
            }
            
            // Hapus file ebook jika ada
            if ($this->ebookToDelete->ebook_file_path) {
                Storage::delete('public/' . $this->ebookToDelete->ebook_file_path);
            }
            
            $this->ebookToDelete->delete();
            
            $this->showDeleteModal = false;
            $this->ebookToDelete = null;
            
            $this->dispatch('showNotification', 
                message: 'E-book berhasil dihapus!',
                type: 'success'
            );
        }
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->ebookToDelete = null;
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->sort = 'latest';
        $this->resetPage();
    }

    public function render()
    {
        $query = Ebook::query()->with('category');
        
        // Search functionality
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'LIKE', "%{$this->search}%")
                  ->orWhere('author', 'LIKE', "%{$this->search}%")
                  ->orWhere('description', 'LIKE', "%{$this->search}%");
            });
        }
        
        // Category filter
        if ($this->category) {
            $query->whereHas('category', function($q) {
                $q->where('id', $this->category);
            });
        }
        
        // Sort functionality
        switch ($this->sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }
        
        $ebooks = $query->paginate($this->perPage);
        $categories = Category::all();

        return view('livewire.kelola-ebook', [
            'ebooks' => $ebooks,
            'categories' => $categories,
        ]);
    }
}
