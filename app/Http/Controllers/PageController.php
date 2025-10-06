<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function home()
    {
        $ebooks = \App\Models\Ebook::latest()->take(10)->get();
        return view('pages.home', ['title' => 'Beranda', 'ebooks' => $ebooks]);
    }

    public function catalog(Request $request)
    {
        $query = Ebook::query();
        
        // Search functionality
        if ($request->has('q') && $request->q != '') {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('author', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('id', $request->category);
            });
        }
        
        // Sort functionality
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
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
        
        $ebooks = $query->paginate(24);
        $categories = Category::all();
        
        return view('pages.katalog', [
            'title' => 'Katalog', 
            'ebooks' => $ebooks,
            'categories' => $categories,
            'filters' => $request->all()
        ]);
    }

    public function about()
    {
        return view('pages.tentang', ['title' => 'Tentang']);
    }

    public function reader(Ebook $ebook)
    {
        // Simpan URL sebelumnya ke session
        session(['reader_referrer' => url()->previous()]);
        
        return view('pages.reader', ['title' => $ebook->title, 'ebook' => $ebook]);
    }

    public function profile()
    {
        return view('pages.profil', ['title' => 'Pengaturan Profil']);
    }
}