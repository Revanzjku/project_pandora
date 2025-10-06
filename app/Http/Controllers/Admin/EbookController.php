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
            'title' => 'Manajemen Ebook',
            'ebooks' => Ebook::with('category')->latest()->paginate(30),
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
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'author'            => 'required|string|max:255',
            'year'              => 'required|integer|min:1000|max:' . now()->year,
            'description'       => 'nullable|string|max:5000',
            'category_id'       => 'nullable|exists:categories,id',
            'cover_image_path'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ebook_file_path'   => 'required|mimes:zip|max:51200',
            'download_path'     => 'required|mimes:epub,pdf|max:51200',
        ]);

        // Cover
        if ($request->hasFile('cover_image_path')) {
            $validated['cover_image_path'] = $request->file('cover_image_path')->store('ebooks/covers', 'public');
        }

        if ($request->hasFile('download_path')) {
            $path = $request->file('download_path')->store('ebooks/downloads', 'public');
            $validated['download_path'] = $path;
        }

        // Buat record dulu biar dapet ID
        $ebook = Ebook::create($validated);

        // Proses ZIP → extract ke folder per ebook
        if ($request->hasFile('ebook_file_path')) {
            $zip = new ZipArchive;
            $zipPath = $request->file('ebook_file_path')->storeAs('temp', uniqid() . '.zip', 'public');
            $extractPath = storage_path("app/public/ebooks/files/{$ebook->id}");

            // Pastikan folder bersih
            if (File::exists($extractPath)) {
                File::deleteDirectory($extractPath);
            }
            File::makeDirectory($extractPath, 0755, true);

            if ($zip->open(storage_path("app/public/{$zipPath}")) === true) {
                $zip->extractTo($extractPath);
                $zip->close();
            }

            Storage::disk('public')->delete($zipPath);

            // Cari file html utama
            $htmlFiles = File::files($extractPath);
            $htmlFile = collect($htmlFiles)->first(fn($file) => $file->getExtension() === 'html');

            if ($htmlFile) {
                $relativePath = "ebooks/files/{$ebook->id}/" . $htmlFile->getFilename();
                $ebook->update(['ebook_file_path' => $relativePath]);
            }
        }

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
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'author'            => 'required|string|max:255',
            'year'              => 'required|integer|min:1000|max:' . now()->year,
            'description'       => 'nullable|string|max:5000',
            'category_id'       => 'nullable|exists:categories,id',
            'cover_image_path'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ebook_file_path'   => 'nullable|mimes:zip|max:51200',
            'download_path'     => 'nullable|mimes:epub,pdf|max:51200',
        ]);

        // Cover
        if ($request->hasFile('cover_image_path')) {
            if ($ebook->cover_image_path) {
                Storage::disk('public')->delete($ebook->cover_image_path);
            }
            $validated['cover_image_path'] = $request->file('cover_image_path')->store('ebooks/covers', 'public');
        }

        // Download file
        if ($request->hasFile('download_path')) {
            if ($ebook->download_path) {
                Storage::disk('public')->delete($ebook->download_path);
            }
            $path = $request->file('download_path')->store('ebooks/downloads', 'public');
            $validated['download_path'] = $path;
        }

        // ZIP baru
        if ($request->hasFile('ebook_file_path')) {
            $zip = new ZipArchive;
            $zipPath = $request->file('ebook_file_path')->storeAs('temp', uniqid() . '.zip', 'public');
            $extractPath = storage_path("app/public/ebooks/files/{$ebook->id}");

            if (File::exists($extractPath)) {
                File::deleteDirectory($extractPath);
            }
            File::makeDirectory($extractPath, 0755, true);

            if ($zip->open(storage_path("app/public/{$zipPath}")) === true) {
                $zip->extractTo($extractPath);
                $zip->close();
            }

            Storage::disk('public')->delete($zipPath);

            // Cari file html utama
            $htmlFiles = File::files($extractPath);
            $htmlFile = collect($htmlFiles)->first(fn($file) => $file->getExtension() === 'html');

            if ($htmlFile) {
                $validated['ebook_file_path'] = "ebooks/files/{$ebook->id}/" . $htmlFile->getFilename();
            }
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
        if ($ebook->download_path) {
            Storage::disk('public')->delete($ebook->download_path);
        }
        if ($ebook->ebook_file_path) {
            $folder = storage_path("app/public/ebooks/files/{$ebook->id}");
            if (File::exists($folder)) {
                File::deleteDirectory($folder);
            }
        }

        $ebook->delete();

        return redirect()->route('admin.ebooks.index')
            ->with('success', 'Ebook berhasil dihapus!');
    }
}