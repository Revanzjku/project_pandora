<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;
use App\Http\Controllers\Controller;

class EbookController extends Controller
{
    public function index()
    {
        return view('admin.ebook.index', [
            'title' => 'Kelola Ebook',
        ]);
    }

    public function create()
    {
        return view('admin.ebook.form-ebook', [
            'title' => 'Tambah Ebook Baru',
            'ebook' => null // Explicitly set to null for create
        ]);
    }

    public function edit(Ebook $ebook)
    {
        return view('admin.ebook.form-ebook', [
            'title' => 'Edit Ebook',
            'ebook' => $ebook,
        ]);
    }
}