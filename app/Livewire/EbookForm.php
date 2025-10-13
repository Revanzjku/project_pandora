<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ebook;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;

class EbookForm extends Component
{
    use WithFileUploads;

    public $ebookId = null;
    public $title = '';
    public $author = '';
    public $year = '';
    public $description = '';
    public $category_id = '';
    public $cover_image_path;
    public $ebook_file_path;
    public $download_path;
    
    public $existingCover = null;
    public $existingEbookFile = null;
    public $existingDownloadFile = null;

    // Hapus rules dari property, kita akan buat method instead
    protected function rules()
    {
        $currentYear = now()->year;
        
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => "required|integer|min:1000|max:{$currentYear}",
            'description' => 'nullable|string|max:5000',
            'category_id' => 'nullable|exists:categories,id',
            'cover_image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ebook_file_path' => $this->ebookId ? 'nullable|mimes:zip|max:51200' : 'required|mimes:zip|max:51200',
            'download_path' => $this->ebookId ? 'nullable|mimes:epub,pdf|max:51200' : 'required|mimes:epub,pdf|max:51200',
        ];
    }

    public function mount($ebook = null)
    {
        if ($ebook) {
            $this->ebookId = $ebook->id;
            $this->title = $ebook->title;
            $this->author = $ebook->author;
            $this->year = $ebook->year;
            $this->description = $ebook->description;
            $this->category_id = $ebook->category_id;
            
            // Simpan info file existing
            $this->existingCover = $ebook->cover_image_path;
            $this->existingEbookFile = $ebook->ebook_file_path;
            $this->existingDownloadFile = $ebook->download_path;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'author' => $this->author,
            'year' => $this->year,
            'description' => $this->description,
            'category_id' => $this->category_id ?: null,
        ];

        try {
            if ($this->ebookId) {
                // Update existing ebook
                $ebook = Ebook::findOrFail($this->ebookId);
                
                // Handle cover image
                if ($this->cover_image_path) {
                    // Delete old cover
                    if ($ebook->cover_image_path) {
                        Storage::disk('public')->delete($ebook->cover_image_path);
                    }
                    $data['cover_image_path'] = $this->cover_image_path->store('ebooks/covers', 'public');
                }

                // Handle download file
                if ($this->download_path) {
                    // Delete old download file
                    if ($ebook->download_path) {
                        Storage::disk('public')->delete($ebook->download_path);
                    }
                    $data['download_path'] = $this->download_path->store('ebooks/downloads', 'public');
                }

                // Handle ebook file (ZIP extraction)
                if ($this->ebook_file_path) {
                    $this->processZipFile($ebook);
                }

                $ebook->update($data);
                
                session()->flash('notification', [
                    'type' => 'success',
                    'message' => 'E-book berhasil diperbarui!'
                ]);

            } else {
                // Create new ebook - validasi file required
                if (!$this->ebook_file_path) {
                    throw new \Exception('File ebook (ZIP) wajib diisi untuk ebook baru.');
                }
                
                if (!$this->download_path) {
                    throw new \Exception('File download (EPUB/PDF) wajib diisi untuk ebook baru.');
                }

                $ebook = Ebook::create($data);

                // Handle cover image
                if ($this->cover_image_path) {
                    $ebook->cover_image_path = $this->cover_image_path->store('ebooks/covers', 'public');
                }

                // Handle download file
                if ($this->download_path) {
                    $ebook->download_path = $this->download_path->store('ebooks/downloads', 'public');
                }

                // Handle ebook file (ZIP extraction)
                $this->processZipFile($ebook);

                $ebook->save();
                
                session()->flash('notification', [
                    'type' => 'success',
                    'message' => 'E-book berhasil ditambahkan!'
                ]);
            }

            // Redirect ke halaman list
            return redirect()->route('admin.ebooks.index');

        } catch (\Exception $e) {
            $this->dispatch('showNotification', 
                type: 'error',
                message: 'Terjadi kesalahan: ' . $e->getMessage()
            );
        }
    }

    private function processZipFile($ebook)
    {
        $zip = new ZipArchive;
        $zipPath = $this->ebook_file_path->storeAs('temp', uniqid() . '.zip', 'public');
        $extractPath = storage_path("app/public/ebooks/files/{$ebook->id}");

        // Clean existing directory
        if (File::exists($extractPath)) {
            File::deleteDirectory($extractPath);
        }
        File::makeDirectory($extractPath, 0755, true);

        if ($zip->open(storage_path("app/public/{$zipPath}")) === true) {
            $zip->extractTo($extractPath);
            $zip->close();
        } else {
            throw new \Exception('Gagal membuka file ZIP.');
        }

        Storage::disk('public')->delete($zipPath);

        // Find main HTML file
        $htmlFiles = File::files($extractPath);
        $htmlFile = collect($htmlFiles)->first(function($file) {
            return in_array(strtolower($file->getExtension()), ['html', 'htm']);
        });

        if ($htmlFile) {
            $ebook->ebook_file_path = "ebooks/files/{$ebook->id}/" . $htmlFile->getFilename();
            $ebook->save();
        } else {
            // Jika tidak ada HTML file, cari file apa saja sebagai fallback
            $allFiles = File::files($extractPath);
            if (count($allFiles) > 0) {
                $firstFile = $allFiles[0];
                $ebook->ebook_file_path = "ebooks/files/{$ebook->id}/" . $firstFile->getFilename();
                $ebook->save();
            } else {
                throw new \Exception('Tidak ditemukan file dalam ZIP.');
            }
        }
    }

    public function removeCover()
    {
        $this->cover_image_path = null;
    }

    public function removeEbookFile()
    {
        $this->ebook_file_path = null;
    }

    public function removeDownloadFile()
    {
        $this->download_path = null;
    }

    public function render()
    {
        return view('livewire.ebook-form', [
            'categories' => Category::all(),
            'isEdit' => !is_null($this->ebookId),
        ]);
    }
}