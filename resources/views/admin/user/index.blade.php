@extends('layouts.app')

@section('content')
    <x-navbar />
    <div class="flex">
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1 lg:ml-0" x-data="{ 
            showModal: false, 
            showHistoryModal: false,
            user: {},
            userActivities: []
        }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Page Header -->
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h1 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-2">
                            Kelola Pengguna
                        </h1>
                        <p class="text-slate-600">
                            Mengelola daftar pengguna yang terdaftar di sistem.
                        </p>
                    </div>
                    {{-- Tombol Tambah Pengguna diaktifkan --}}
                    <a href="{{ route('admin.users.create') }}" 
                       class="px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                       Tambah Pengguna
                    </a>
                </div>

                @if (session('success'))
                    <div class="mb-6 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($users as $user)
                                    <tr>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center space-x-4">
                                                <!-- Tombol Detail -->
                                                <button 
                                                    class="text-gray-600 hover:underline"
                                                    @click="
                                                        user = {
                                                            name: '{{ $user->name }}',
                                                            email: '{{ $user->email }}',
                                                            role: '{{ ucfirst($user->role) }}',
                                                            join_date: '{{ $user->created_at->format('d F Y') }}',
                                                            role_class: '{{ $user->role == 'admin' ? 'bg-sky-100 text-sky-800' : 'bg-slate-100 text-slate-800' }}'
                                                        };
                                                        showModal = true;
                                                    ">
                                                    Detail
                                                </button>
                                                <!-- Tombol Riwayat -->
                                                <button 
                                                    class="text-indigo-600 hover:underline"
                                                    @click="
                                                        user = {
                                                            id: {{ $user->id }},
                                                            name: '{{ $user->name }}',
                                                            email: '{{ $user->email }}'
                                                        };
                                                        userActivities = [
                                                            @foreach($user->activities as $activity)
                                                            {
                                                                id: {{ $activity->id }},
                                                                ebook_title: '{{ $activity->ebook->title ?? 'Tidak diketahui' }}',
                                                                activity_type: '{{ $activity->activity_type }}',
                                                                activity_display: '{{ $activity->activity_type == 'read' ? 'Membaca' : ($activity->activity_type == 'download' ? 'Mendownload' : 'Mengutip') }}',
                                                                created_at: '{{ $activity->created_at->format('d F Y, H:i') }}'
                                                            }@if(!$loop->last),@endif
                                                            @endforeach
                                                        ];
                                                        showHistoryModal = true;
                                                    ">
                                                    Riwayat
                                                </button>
                                                <a href="{{ route('admin.users.edit', $user) }}" class="text-sky-600 hover:underline">Edit</a>
                                                <form action="{{ route('admin.users.destroy', $user) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 text-slate-500">
                                        Tidak ada data pengguna.
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
                                <div class="bg-slate-50 p-4 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="text-base font-bold text-slate-900">{{ $user->name }}</h3>
                                            <p class="text-sm text-slate-600">{{ $user->email }}</p>
                                        </div>
                                        <div>
                                            <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $user->role == 'admin' ? 'bg-sky-100 text-sky-800' : 'bg-slate-100 text-slate-800' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </div>
                                    </div>
                                   
                                    <div class="flex justify-end items-center border-t border-slate-200 pt-3 space-x-4 text-sm">
                                        <!-- Tombol Detail untuk Mobile -->
                                        <button 
                                            class="text-gray-600 hover:underline"
                                            @click="
                                                user = {
                                                    name: '{{ $user->name }}',
                                                    email: '{{ $user->email }}',
                                                    role: '{{ ucfirst($user->role) }}',
                                                    join_date: '{{ $user->created_at->format('d F Y') }}',
                                                    role_class: '{{ $user->role == 'admin' ? 'bg-sky-100 text-sky-800' : 'bg-slate-100 text-slate-800' }}'
                                                };
                                                showModal = true;
                                            ">
                                            Detail
                                        </button>
                                        <!-- Tombol Riwayat untuk Mobile -->
                                        <button 
                                            class="text-indigo-600 hover:underline"
                                            @click="
                                                user = {
                                                    id: {{ $user->id }},
                                                    name: '{{ $user->name }}',
                                                    email: '{{ $user->email }}'
                                                };
                                                userActivities = [
                                                    @foreach($user->activities as $activity)
                                                    {
                                                        id: {{ $activity->id }},
                                                        ebook_title: '{{ $activity->ebook->title ?? 'Tidak diketahui' }}',
                                                        activity_type: '{{ $activity->activity_type }}',
                                                        activity_display: '{{ $activity->activity_type == 'read' ? 'Membaca' : ($activity->activity_type == 'download' ? 'Mendownload' : 'Mengutip') }}',
                                                        created_at: '{{ $activity->created_at->format('d F Y, H:i') }}'
                                                    }@if(!$loop->last),@endif
                                                    @endforeach
                                                ];
                                                showHistoryModal = true;
                                            ">
                                            Riwayat
                                        </button>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-sky-600 hover:underline">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" 
                                                method="POST" 
                                                onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 text-slate-500">
                                    Tidak ada data pengguna.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Modal Detail Pengguna -->
                <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                    <div @click.away="showModal = false" class="bg-white rounded-2xl shadow-lg max-w-md w-full p-6 mx-4">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Detail Pengguna</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-slate-200 rounded-full flex items-center justify-center">
                                    <span class="text-2xl font-bold text-slate-600" x-text="user.name?.charAt(0) || 'U'"></span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900" x-text="user.name || '-'"></h3>
                                    <p class="text-sm text-slate-600" x-text="user.email || '-'"></p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-200">
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Role</p>
                                    <span x-text="user.role || '-'" 
                                          :class="user.role_class + ' px-2.5 py-1 text-xs font-medium rounded-full'">
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Tanggal Bergabung</p>
                                    <p class="text-sm text-slate-900" x-text="user.join_date || '-'"></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button @click="showModal = false" class="px-4 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Riwayat Aktivitas -->
                <div x-show="showHistoryModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                    <div @click.away="showHistoryModal = false" class="bg-white rounded-2xl shadow-lg max-w-2xl w-full p-6 mx-4 max-h-[80vh] overflow-hidden">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900">Riwayat Aktivitas</h2>
                                <p class="text-sm text-slate-600" x-text="user.name + ' (' + user.email + ')'"></p>
                            </div>
                            <button @click="showHistoryModal = false" class="text-slate-400 hover:text-slate-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="overflow-y-auto max-h-96">
                            <template x-if="userActivities.length === 0">
                                <div class="text-center py-8 text-slate-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada aktivitas</p>
                                    <p class="text-sm">Pengguna ini belum melakukan aktivitas apapun</p>
                                </div>
                            </template>
                            
                            <template x-if="userActivities.length > 0">
                                <div class="space-y-3">
                                    <template x-for="activity in userActivities" :key="activity.id">
                                        <div class="flex items-start space-x-3 p-3 bg-slate-50 rounded-lg">
                                            <!-- Icon berdasarkan jenis aktivitas -->
                                            <div class="flex-shrink-0 mt-1">
                                                <template x-if="activity.activity_type === 'read'">
                                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                        </svg>
                                                    </div>
                                                </template>
                                                <template x-if="activity.activity_type === 'download'">
                                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                    </div>
                                                </template>
                                                <template x-if="activity.activity_type === 'cite'">
                                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                        </svg>
                                                    </div>
                                                </template>
                                            </div>
                                            
                                            <!-- Konten aktivitas -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between">
                                                    <p class="text-sm font-medium text-slate-900" x-text="activity.activity_display"></p>
                                                    <span class="text-xs text-slate-500" x-text="activity.created_at"></span>
                                                </div>
                                                <p class="text-sm text-slate-600" x-text="activity.ebook_title"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                        
                        <div class="mt-6 flex justify-end border-t border-slate-200 pt-4">
                            <button @click="showHistoryModal = false" class="px-4 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                     <nav class="flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <p class="text-sm text-slate-600">
                                Menampilkan {{ $users->firstItem() }}-{{ $users->lastItem() }} dari {{ $users->total() }} data
                            </p>
                        </div>
                        <div>
                            <ul class="inline-flex items-center space-x-2">
                                {{-- Previous --}}
                                @if ($users->onFirstPage())
                                    <li><span class="px-3 py-1 text-sm font-medium text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed">Sebelumnya</span></li>
                                @else
                                    <li><a href="{{ $users->previousPageUrl() }}" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">Sebelumnya</a></li>
                                @endif
                                {{-- Number --}}
                                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    @if ($page == $users->currentPage())
                                        <li><span class="px-3 py-1 text-sm font-medium text-white bg-sky-600 rounded-lg">{{ $page }}</span></li>
                                    @else
                                        <li><a href="{{ $url }}" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                                {{-- Next --}}
                                @if ($users->hasMorePages())
                                    <li><a href="{{ $users->nextPageUrl() }}" class="px-3 py-1 text-sm font-medium text-slate-600 bg-white rounded-lg hover:bg-slate-100">Berikutnya</a></li>
                                @else
                                    <li><span class="px-3 py-1 text-sm font-medium text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed">Berikutnya</span></li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection