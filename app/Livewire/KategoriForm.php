<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class KategoriForm extends Component
{
    public $categoryId = null;
    public $name = '';

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string', 
                'max:255',
                'unique:categories,name' . ($this->categoryId ? ',' . $this->categoryId : '')
            ],
        ];
    }

    public function mount($category = null)
    {
        if ($category) {
            $this->categoryId = $category->id;
            $this->name = $category->name;
        }
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->categoryId) {
                // Update existing category
                $category = Category::findOrFail($this->categoryId);
                $category->update(['name' => $this->name]);
                
                session()->flash('notification', [
                    'type' => 'success',
                    'message' => 'Kategori berhasil diperbarui!'
                ]);
            } else {
                // Create new category
                Category::create(['name' => $this->name]);
                
                session()->flash('notification', [
                    'type' => 'success', 
                    'message' => 'Kategori berhasil ditambahkan!'
                ]);
            }

            // Redirect ke halaman list
            return redirect()->route('admin.categories.index');

        } catch (\Exception $e) {
            session()->flash('notification', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.kategori-form', [
            'isEdit' => !is_null($this->categoryId),
        ]);
    }
}
