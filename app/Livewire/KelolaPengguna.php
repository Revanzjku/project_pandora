<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class KelolaPengguna extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';
    public $perPage = 10;
    
    // Modal states
    public $showDetailModal = false;
    public $showHistoryModal = false;
    public $showDeleteModal = false;
    public $selectedUser = null;
    public $userToDelete = null;
    public $userActivities = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function showDetail($userId)
    {
        $user = User::withCount('activities')->findOrFail($userId);
        $this->selectedUser = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'role_display' => ucfirst($user->role),
            'role_class' => $user->role == 'admin' ? 'bg-sky-100 text-sky-800' : 'bg-slate-100 text-slate-800',
            'join_date' => $user->created_at->format('d F Y'),
            'activities_count' => $user->activities_count,
        ];
        $this->showDetailModal = true;
    }

    public function showHistory($userId)
    {
        $user = User::with(['activities' => function($q) {
            $q->with('ebook')->latest()->limit(10);
        }])->findOrFail($userId);

        $this->selectedUser = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        $this->userActivities = $user->activities->map(function($activity) {
            return [
                'id' => $activity->id,
                'ebook_title' => $activity->ebook->title ?? 'Tidak diketahui',
                'activity_type' => $activity->activity_type,
                'activity_display' => $this->getActivityDisplay($activity->activity_type),
                'created_at' => $activity->created_at->format('d F Y, H:i'),
                'icon_class' => $this->getActivityIconClass($activity->activity_type),
            ];
        })->toArray();

        $this->showHistoryModal = true;
    }

    private function getActivityDisplay($type)
    {
        return match($type) {
            'read' => 'Membaca',
            'download' => 'Mendownload', 
            'cite' => 'Mengutip',
            default => 'Aktivitas'
        };
    }

    private function getActivityIconClass($type)
    {
        return match($type) {
            'read' => 'bg-green-100 text-green-600',
            'download' => 'bg-blue-100 text-blue-600',
            'cite' => 'bg-purple-100 text-purple-600',
            default => 'bg-slate-100 text-slate-600'
        };
    }

    public function confirmDelete($userId)
    {
        $user = User::findOrFail($userId);
        $this->userToDelete = $user;
        $this->showDeleteModal = true;
    }

    public function deleteUser()
    {
        if ($this->userToDelete) {
            $userName = $this->userToDelete->name;
            $this->userToDelete->delete();
            
            $this->showDeleteModal = false;
            $this->userToDelete = null;
            
            $this->dispatch('showNotification', 
                type: 'success',
                message: "Pengguna {$userName} berhasil dihapus!"
            );
        }
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedUser = null;
    }

    public function closeHistoryModal()
    {
        $this->showHistoryModal = false;
        $this->selectedUser = null;
        $this->userActivities = [];
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->userToDelete = null;
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->role = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query()->withCount('activities');
        
        // Search functionality
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'LIKE', "%{$this->search}%")
                  ->orWhere('email', 'LIKE', "%{$this->search}%");
            });
        }
        
        // Role filter
        if ($this->role) {
            $query->where('role', $this->role);
        }
        
        $users = $query->latest()->paginate($this->perPage);

        return view('livewire.kelola-pengguna', [
            'users' => $users,
        ]);
    }
}
