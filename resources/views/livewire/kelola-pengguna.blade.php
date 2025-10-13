<div>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-2">
                Kelola Pengguna
            </h1>
            <p class="text-slate-600">
                Mengelola daftar pengguna yang terdaftar di sistem.
            </p>
        </div>
        <!-- HAPUS Tombol Tambah Pengguna -->
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6 mb-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Search Bar -->
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2 bg-slate-50 rounded-lg px-3 py-2 ring-1 ring-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        wire:model.live.debounce.500ms="search"
                        placeholder="Cari nama atau email pengguna..." 
                        class="w-full bg-transparent focus:outline-none text-slate-700 placeholder-slate-400">
                    @if($search)
                        <button 
                            wire:click="$set('search', '')"
                            class="p-1 text-slate-400 hover:text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Role Filter -->
            <div>
                <select 
                    wire:model.live="role"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none bg-white">
                    <option value="">Semua Role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>

        <!-- Active Filters -->
        @if($search || $role)
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <span class="text-sm text-slate-600">Filter aktif:</span>
                <div class="flex flex-wrap gap-2">
                    @if($search)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-sky-100 text-sky-800">
                            Pencarian: {{ $search }}
                            <button 
                                wire:click="$set('search', '')" 
                                class="ml-1 hover:text-sky-900">
                                ×
                            </button>
                        </span>
                    @endif
                    @if($role)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-slate-100 text-slate-800">
                            Role: {{ $role == 'admin' ? 'Admin' : 'User' }}
                            <button 
                                wire:click="$set('role', '')" 
                                class="ml-1 hover:text-slate-900">
                                ×
                            </button>
                        </span>
                    @endif
                </div>
                <button 
                    wire:click="resetFilters"
                    class="text-sm text-sky-600 hover:text-sky-700 font-medium">
                    Reset Filter
                </button>
            </div>
        @endif
    </div>

    <!-- Results Info -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="heading text-xl font-semibold text-slate-900">
                @if($search || $role)
                    Hasil Pencarian
                @else
                    Semua Pengguna
                @endif
            </h2>
            <p class="text-sm text-slate-600 mt-1">
                Menampilkan {{ $users->count() }} dari {{ $users->total() }} pengguna
            </p>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
        <!-- Desktop View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aktivitas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $users->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-medium">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $user->role == 'admin' ? 'bg-sky-100 text-sky-800' : 'bg-slate-100 text-slate-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $user->activities_count }} aktivitas
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-4">
                                    <!-- Tombol Detail -->
                                    <button 
                                        wire:click="showDetail({{ $user->id }})"
                                        class="text-sky-600 hover:text-sky-700 hover:underline transition-colors">
                                        Detail
                                    </button>
                                    <!-- Tombol Riwayat -->
                                    <button 
                                        wire:click="showHistory({{ $user->id }})"
                                        class="text-indigo-600 hover:text-indigo-700 hover:underline transition-colors">
                                        Riwayat
                                    </button>
                                    <!-- HAPUS Tombol Edit -->
                                    <!-- Tombol Hapus -->
                                    <button 
                                        wire:click="confirmDelete({{ $user->id }})"
                                        class="text-red-600 hover:text-red-700 hover:underline transition-colors">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-slate-500">
                                @if($search || $role)
                                    Tidak ada pengguna ditemukan
                                @else
                                    Belum ada data pengguna.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden">
            <div class="grid grid-cols-1 gap-4">
                @forelse ($users as $user)
                    <div class="bg-slate-50 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h3 class="text-base font-bold text-slate-900">{{ $user->name }}</h3>
                                <p class="text-sm text-slate-600">{{ $user->email }}</p>
                            </div>
                            <div>
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $user->role == 'admin' ? 'bg-sky-100 text-sky-800' : 'bg-slate-100 text-slate-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-slate-600">{{ $user->activities_count }} aktivitas</span>
                        </div>
                       
                        <div class="flex justify-between items-center border-t border-slate-200 pt-3 space-x-4 text-sm">
                            <button 
                                wire:click="showDetail({{ $user->id }})"
                                class="text-sky-600 hover:text-sky-700 font-medium">
                                Detail
                            </button>
                            <button 
                                wire:click="showHistory({{ $user->id }})"
                                class="text-indigo-600 hover:text-indigo-700 font-medium">
                                Riwayat
                            </button>
                            <button 
                                wire:click="confirmDelete({{ $user->id }})"
                                class="text-red-600 hover:text-red-700 font-medium">
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-slate-500">
                        @if($search || $role)
                            Tidak ada pengguna ditemukan
                        @else
                            Belum ada data pengguna.
                        @endif
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if ($users->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $users->links() }}
        </div>
    @endif

    <!-- Detail Modal -->
    <div x-data x-show="$wire.showDetailModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/60 z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-slate-100 mb-4">
                    <span class="text-2xl font-bold text-slate-600" x-text="$wire.selectedUser?.name?.charAt(0) || 'U'"></span>
                </div>
                
                <h3 class="text-lg font-semibold text-slate-900 mb-2" x-text="$wire.selectedUser?.name || '-'"></h3>
                <p class="text-sm text-slate-600 mb-4" x-text="$wire.selectedUser?.email || '-'"></p>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-xs font-medium text-slate-500">Role</p>
                        <span x-text="$wire.selectedUser?.role_display || '-'" 
                              :class="($wire.selectedUser?.role_class || 'bg-slate-100 text-slate-800') + ' px-2.5 py-1 text-xs font-medium rounded-full'">
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500">Bergabung</p>
                        <p class="text-sm text-slate-900" x-text="$wire.selectedUser?.join_date || '-'"></p>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-lg p-3 mb-4">
                    <p class="text-sm font-medium text-slate-700">
                        Total Aktivitas: <span x-text="$wire.selectedUser?.activities_count || '0'"></span>
                    </p>
                </div>
                
                <div class="flex gap-3 justify-center">
                    <button 
                        wire:click="closeDetailModal"
                        class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors font-medium">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div x-data x-show="$wire.showHistoryModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/60 z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-slate-900">Riwayat Aktivitas</h3>
                        <p class="text-sm text-slate-600" x-text="'{{ $selectedUser['name'] ?? '' }} ({{ $selectedUser['email'] ?? '' }})'"></p>
                    </div>
                    <button wire:click="closeHistoryModal" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6">
                @if(count($userActivities) > 0)
                    <div class="space-y-3">
                        @foreach($userActivities as $activity)
                            <div class="flex items-start space-x-3 p-3 bg-slate-50 rounded-lg">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $activity['icon_class'] }}">
                                        @if($activity['activity_type'] === 'read')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        @elseif($activity['activity_type'] === 'download')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-slate-900">{{ $activity['activity_display'] }}</p>
                                        <span class="text-xs text-slate-500">{{ $activity['created_at'] }}</span>
                                    </div>
                                    <p class="text-sm text-slate-600">{{ $activity['ebook_title'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-slate-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-lg font-medium">Belum ada aktivitas</p>
                        <p class="text-sm">Pengguna ini belum melakukan aktivitas apapun</p>
                    </div>
                @endif
            </div>
            
            <div class="p-6 border-t border-slate-200">
                <div class="flex justify-end">
                    <button 
                        wire:click="closeHistoryModal"
                        class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors font-medium">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data x-show="$wire.showDeleteModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/60 z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
            <div class="text-center">
                <!-- Warning Icon -->
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                
                <h3 class="text-lg font-semibold text-slate-900 mb-2">
                    Hapus Pengguna?
                </h3>
                
                <p class="text-slate-600 mb-6">
                    Apakah Anda yakin ingin menghapus pengguna 
                    <span class="font-semibold">"{{ $userToDelete->name ?? '' }}"</span>? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
                
                <div class="flex gap-3 justify-center">
                    <button 
                        wire:click="closeDeleteModal"
                        class="px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button 
                        wire:click="deleteUser"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>