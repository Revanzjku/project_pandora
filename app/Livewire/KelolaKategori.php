<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class KelolaKategori extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    
    // Modal states
    public $showDeleteModal = false;
    public $categoryToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $this->categoryToDelete = $category;
        $this->showDeleteModal = true;
    }

    public function deleteCategory()
    {
        if ($this->categoryToDelete) {
            // Cek apakah kategori digunakan oleh ebook
            if ($this->categoryToDelete->ebooks()->exists()) {
                session()->flash('notification', [
                    'type' => 'error',
                    'message' => 'Kategori tidak dapat dihapus karena masih digunakan oleh beberapa ebook.'
                ]);
            } else {
                $this->categoryToDelete->delete();
                
                $this->dispatch('showNotification', 
                    message: 'Kategori berhasil dihapus!',
                    type: 'success'
                );
            }
            
            $this->showDeleteModal = false;
            $this->categoryToDelete = null;
        }
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->categoryToDelete = null;
    }

    public function render()
    {
        $query = Category::with('ebooks');
        
        // Search functionality
        if ($this->search) {
            $query->where('name', 'LIKE', "%{$this->search}%");
        }
        
        $categories = $query->latest()->paginate($this->perPage);

        return view('livewire.kelola-kategori', [
            'categories' => $categories,
        ]);
    }
}
