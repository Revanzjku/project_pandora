<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ebook;
use App\Models\Category;
use Illuminate\Support\Facades\URL;

class KatalogPage extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $sort = 'latest';
    public $perPage = 24;

    // Untuk modal
    public $showModal = false;
    public $showCitationModal = false;
    public $selectedEbook = null;
    public $citationStyle = 'apa';

    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q'],
        'category' => ['except' => ''],
        'sort' => ['except' => 'latest']
    ];

    public function mount()
    {
        // Sync dengan query string URL jika ada
        $this->search = request('q', '');
        $this->category = request('category', '');
        $this->sort = request('sort', 'latest');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingSort()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->sort = 'latest';
        $this->resetPage();
    }

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
            'file' => $ebook->ebook_file_path ? asset('storage/' . $ebook->ebook_file_path) : null
        ];
        $this->showModal = true;
    }

    public function showCitation()
    {
        if ($this->selectedEbook) {
            $this->showModal = false;
            $this->showCitationModal = true;
        }
    }

    // Method helper untuk mendapatkan citation text (tanpa HTML)
    public function getCitationText($style, $ebook)
    {
        $citation = $this->generateCitation($style, $ebook);
        return strip_tags($citation); // Hapus tag HTML
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
        $query = Ebook::query()->with('category');
        
        // Search functionality
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'LIKE', "%{$this->search}%")
                  ->orWhere('author', 'LIKE', "%{$this->search}%")
                  ->orWhere('description', 'LIKE', "%{$this->search}%");
            });
        }
        
        // Category filter
        if ($this->category) {
            $query->whereHas('category', function($q) {
                $q->where('id', $this->category);
            });
        }
        
        // Sort functionality
        switch ($this->sort) {
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
        
        $ebooks = $query->paginate($this->perPage);
        $categories = Category::all();

        return view('livewire.katalog-page', [
            'ebooks' => $ebooks,
            'categories' => $categories,
        ]);
    }
}