<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ebook;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EbookModal extends Component
{
    // Properties yang akan di-pass dari parent
    public $showModal = false;
    public $showCitationModal = false;
    public $selectedEbook = null;
    public $citationStyle = 'apa';

    // Events yang akan di-emit ke parent
    protected $listeners = [
        'showDetail' => 'showDetail',
        'showCitation' => 'showCitation',
        'backToDetail' => 'backToDetail'
    ];

    public function showDetail($ebookId)
    {
        $ebook = Ebook::with('category')->findOrFail($ebookId);
        $this->selectedEbook = [
            'id' => $ebook->id,
            'title' => $ebook->title,
            'slug' => $ebook->slug,
            'author' => $ebook->author,
            'year' => $ebook->year,
            'category' => $ebook->category->name ?? '-',
            'description' => $ebook->description,
            'cover' => $ebook->cover_image_path ? asset('storage/' . $ebook->cover_image_path) : null,
            'file' => $ebook->ebook_file_path ? asset('storage/' . $ebook->ebook_file_path) : null,
        ];
        $this->showModal = true;
    }

    public function showCitation()
    {
        if ($this->selectedEbook) {
            // Logging aktivitas kutipan
            $ebook = Ebook::find($this->selectedEbook['id']);
            if ($ebook && Auth::check()) {
                LogActivity::create([
                    'user_id' => Auth::user()->id,
                    'ebook_id' => $ebook->id,
                    'activity_type' => 'cite',
                ]);
            }
            $this->showModal = false;
            $this->showCitationModal = true;
        }
    }

    public function backToDetail()
    {
        if ($this->selectedEbook) {
            $this->showCitationModal = false;
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedEbook = null;
    }

    public function closeCitationModal()
    {
        $this->showCitationModal = false;
    }

    // Method untuk download ebook
    public function downloadEbook()
    {
        if (!$this->selectedEbook || !$this->selectedEbook['file']) {
            return;
        }

        $ebook = Ebook::find($this->selectedEbook['id']);
        if (!$ebook || !$ebook->ebook_file_path) {
            return;
        }

        $filePath = storage_path('app/public/' . $ebook->download_path);
        
        if (!file_exists($filePath)) {
            return;
        }

        LogActivity::create([
            'user_id' => Auth::user()->id,
            'ebook_id' => $ebook->id,
            'activity_type' => 'download',
        ]);

        $fileName = Str::slug($ebook->title) . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
        
        return response()->download($filePath, $fileName);
    }

    // Method helper untuk mendapatkan citation text (tanpa HTML)
    public function getCitationText($style, $ebook)
    {
        $citation = $this->generateCitation($style, $ebook);

        return strip_tags($citation);
    }

    public function generateCitation($style, $ebook)
    {
        $authors = $ebook['author'] ? explode(', ', $ebook['author']) : ['Anonim'];
        $year = $ebook['year'] ?: 't.t.';
        $title = $ebook['title'] ?: 'Judul tidak tersedia';

        // Format nama penulis untuk semua gaya
        $formatAuthorNames = function($authors, $style) {
            if (empty($authors)) return 'Anonim';
            
            $formatSingleAuthor = function($author, $style) {
                $parts = explode(' ', $author);
                if (count($parts) === 1) return $author;
                
                switch($style) {
                    case 'apa':
                        $lastname = $parts[count($parts) - 1];
                        $initials = implode(' ', array_map(function($name) {
                            return $name[0] . '.';
                        }, array_slice($parts, 0, -1)));
                        return "{$lastname}, {$initials}";
                    
                    case 'chicago':
                    case 'mla':
                        $lastname = $parts[count($parts) - 1];
                        $firstnames = implode(' ', array_slice($parts, 0, -1));
                        return "{$lastname}, {$firstnames}";
                    
                    default:
                        return $author;
                }
            };

            if (count($authors) === 1) {
                return $formatSingleAuthor($authors[0], $style);
            }
            
            $formattedAuthors = array_map(function($author) use ($formatSingleAuthor, $style) {
                return $formatSingleAuthor($author, $style);
            }, $authors);
            
            switch($style) {
                case 'apa':
                    if (count($authors) === 2) {
                        return "{$formattedAuthors[0]} & {$formattedAuthors[1]}";
                    } else {
                        return "{$formattedAuthors[0]} et al.";
                    }
                
                case 'chicago':
                    if (count($authors) === 2) {
                        return "{$formattedAuthors[0]} and {$formattedAuthors[1]}";
                    } else {
                        return "{$formattedAuthors[0]}, {$formattedAuthors[1]}, and {$formattedAuthors[2]}";
                    }
                
                case 'mla':
                    if (count($authors) === 2) {
                        return "{$formattedAuthors[0]}, and {$formattedAuthors[1]}";
                    } else {
                        return "{$formattedAuthors[0]}, et al.";
                    }
                
                default:
                    return $formattedAuthors[0];
            }
        };

        $formattedAuthors = $formatAuthorNames($authors, $style);
        
        switch($style) {
            case 'apa':
                return "{$formattedAuthors} ({$year}). <em>{$title}</em>.";
            
            case 'chicago':
                return "{$formattedAuthors}. {$year}. <em>{$title}</em>.";
            
            case 'mla':
                return "{$formattedAuthors}. <em>{$title}</em>. {$year}.";
            
            default:
                return "{$formattedAuthors} ({$year}). {$title}.";
        }
    }

    public function render()
    {
        return view('livewire.ebook-modal');
    }
}
