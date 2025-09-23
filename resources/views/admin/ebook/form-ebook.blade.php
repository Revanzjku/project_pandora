@extends('layouts.app')

@section('content')
    <x-navbar />
    <div class="flex">
        <x-sidebar />

        <div class="flex-1">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                
                <div class="mb-10">
                    <h1 class="text-3xl font-bold text-slate-900">{{ isset($ebook) ? 'Edit Ebook' : 'Tambah Ebook Baru' }}</h1>
                    <p class="mt-1 text-slate-600">{{ isset($ebook) ? 'Perbarui data ebook yang ada.' : 'Tambahkan data ebook baru ke sistem.' }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg ring-1 ring-slate-200/70 p-8 transition hover:shadow-xl">
                    <form action="{{ isset($ebook) ? route('admin.ebooks.update', $ebook->id) : route('admin.ebooks.store') }}"
                          method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @if (isset($ebook))
                            @method('PUT')
                        @endif

                        <div>
                            <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Judul</label>
                            <input type="text" name="title" id="title"
                                   class="block w-full rounded-xl border @error('title') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                                   value="{{ old('title', $ebook->title ?? '') }}" required>
                            @error('title')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="author" class="block text-sm font-medium text-slate-700 mb-1">Penulis</label>
                            <input type="text" name="author" id="author"
                                   class="block w-full rounded-xl border @error('author') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                                   value="{{ old('author', $ebook->author ?? '') }}" required>
                            @error('author')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="year" class="block text-sm font-medium text-slate-700 mb-1">Tahun</label>
                            <input type="number" name="year" id="year"
                                   class="block w-full rounded-xl border @error('year') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                                   value="{{ old('year', $ebook->year ?? '') }}" required>
                            @error('year')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cover_image" class="block text-sm font-medium text-slate-700 mb-1">Gambar Cover</label>
                            <input type="file" name="cover_image_path" id="cover_image"
                                   class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                            <img id="coverPreview" class="hidden mt-3 w-40 rounded-lg shadow-md">
                            @error('cover_image_path')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            @if (isset($ebook) && $ebook->cover_image_path)
                                <p class="mt-2 text-sm text-slate-600">
                                    Gambar saat ini: 
                                    <a href="{{ asset('storage/' . $ebook->cover_image_path) }}" target="_blank"
                                       class="text-sky-600 hover:underline">Lihat Cover</a>
                                </p>
                            @endif
                        </div>

                        <div>
                            <label for="file_path" class="block text-sm font-medium text-slate-700 mb-1">File Ebook</label>
                            <input type="file" name="ebook_file_path" id="file_path"
                                   class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                            @error('ebook_file_path')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            @if (isset($ebook) && $ebook->ebook_file_path)
                                <p class="mt-2 text-sm text-slate-600">
                                    File saat ini:
                                    <a href="{{ asset('storage/' . $ebook->ebook_file_path) }}" target="_blank"
                                       class="text-sky-600 hover:underline">Unduh File</a>
                                </p>
                            @endif
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                            <select name="category_id" id="category_id"
                                    class="block w-full rounded-xl border @error('category_id') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                                
                                {{-- Opsi kosong / tanpa kategori --}}
                                <option value="">Tanpa Kategori</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $ebook->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                            <textarea name="description" id="description" rows="4"
                                      class="block w-full rounded-xl border @error('description') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none resize-none"
                                      placeholder="Tulis deskripsi singkat tentang ebook...">{{ old('description', $ebook->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center space-x-3 pt-4">
                            <button type="submit"
                                    class="px-5 py-2.5 bg-sky-600 text-white text-sm font-medium rounded-xl hover:bg-sky-700 focus:ring-2 focus:ring-sky-400 focus:outline-none transition">
                                {{ isset($ebook) ? 'Perbarui' : 'Simpan' }}
                            </button>
                            <a href="{{ route('admin.ebooks.index') }}"
                               class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const coverInput = document.getElementById('cover_image');
        const coverPreview = document.getElementById('coverPreview');

        coverInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                coverPreview.src = URL.createObjectURL(file);
                coverPreview.classList.remove('hidden');
            }
        });
    </script>
@endsection