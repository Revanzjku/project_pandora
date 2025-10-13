<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ebook;

class HomePage extends Component
{
    public function render()
    {
        $ebooks = Ebook::with('category')->latest()->take(10)->get();
        return view('livewire.home-page', [
            'ebooks' => $ebooks
        ]);
    }
}