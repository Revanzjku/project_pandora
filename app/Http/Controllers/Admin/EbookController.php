<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class EbookController extends Controller
{
    public function index()
    {
        return view('admin.ebook.index', [
            'title' => 'Manajemen Ebook',
            'ebooks' => Ebook::with('category')->latest()->paginate(5)
        ]);
    }

    public function create()
    {
        return view('admin.ebook.form-ebook', [
            'title' => 'Tambah Ebook Baru',
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'author'            => 'required|string|max:255',
            'year'              => 'required|integer|min:1000|max:' . now()->year,
            'description'       => 'nullable|string|max:5000',
            'category_id'       => 'nullable|exists:categories,id',
            'cover_image_path'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ebook_file_path'   => 'required|mimes:pdf,epub|max:51200', // max 50MB
        ]);

        // Upload cover jika ada
        if ($request->hasFile('cover_image_path')) {
            $validated['cover_image_path'] = $request->file('cover_image_path')->store('ebooks/covers', 'public');
        }

        // Upload file ebook
        if ($request->hasFile('ebook_file_path')) {
            $validated['ebook_file_path'] = $request->file('ebook_file_path')->store('ebooks/files', 'public');
        }

        Ebook::create($validated);

        return redirect()->route('admin.ebooks.index')
            ->with('success', 'Ebook berhasil ditambahkan!');
    }

    public function edit(Ebook $ebook)
    {
        return view('admin.ebook.form-ebook', [
            'title' => 'Edit Ebook',
            'ebook' => $ebook,
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, Ebook $ebook)
    {
        // Validasi
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'author'            => 'required|string|max:255',
            'year'              => 'required|integer|min:1000|max:' . now()->year,
            'description'       => 'nullable|string|max:5000',
            'category_id'       => 'nullable|exists:categories,id',
            'cover_image_path'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ebook_file_path'   => 'nullable|mimes:pdf,epub|max:51200', // ← tidak wajib saat update
        ]);

        // Update cover jika ada file baru
        if ($request->hasFile('cover_image_path')) {
            if ($ebook->cover_image_path) {
                Storage::disk('public')->delete($ebook->cover_image_path);
            }
            $validated['cover_image_path'] = $request->file('cover_image_path')->store('ebooks/covers', 'public');
        }

        // Update file ebook jika ada file baru
        if ($request->hasFile('ebook_file_path')) {
            if ($ebook->ebook_file_path) {
                Storage::disk('public')->delete($ebook->ebook_file_path);
            }
            $validated['ebook_file_path'] = $request->file('ebook_file_path')->store('ebooks/files', 'public');
        }

        $ebook->update($validated);

        return redirect()->route('admin.ebooks.index')
            ->with('success', 'Ebook berhasil diperbarui!');
    }

    public function destroy(Ebook $ebook)
    {
        if ($ebook->cover_image_path) {
            Storage::disk('public')->delete($ebook->cover_image_path);
        }
        if ($ebook->ebook_file_path) {
            Storage::disk('public')->delete($ebook->ebook_file_path);
        }

        $ebook->delete();

        return redirect()->route('admin.ebooks.index')
            ->with('success', 'Ebook berhasil dihapus!');
    }
}