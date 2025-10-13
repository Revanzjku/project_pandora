<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Category;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', ['title' => 'Beranda',]);
    }

    public function catalog()
    {
        return view('pages.katalog', [
            'title' => 'Katalog', 
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

        LogActivity::create([
            'user_id' => Auth::user()->id,
            'ebook_id' => $ebook->id,
            'activity_type' => 'read',
        ]);
        
        return view('pages.reader', ['title' => $ebook->title, 'ebook' => $ebook]);
    }

    public function profile()
    {
        return view('pages.profil', ['title' => 'Pengaturan Profil']);
    }
}