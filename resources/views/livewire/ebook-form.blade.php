<div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-slate-900">{{ $isEdit ? 'Edit Ebook' : 'Tambah Ebook Baru' }}</h1>
            <p class="mt-1 text-slate-600">{{ $isEdit ? 'Perbarui data ebook yang ada.' : 'Tambahkan data ebook baru ke sistem.' }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg ring-1 ring-slate-200/70 p-8 transition hover:shadow-xl">
            <form wire:submit="save" class="space-y-6">
                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Judul</label>
                    <input type="text" wire:model="title" id="title"
                           class="block w-full rounded-xl border @error('title') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                           required>
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penulis -->
                <div>
                    <label for="author" class="block text-sm font-medium text-slate-700 mb-1">Penulis</label>
                    <input type="text" wire:model="author" id="author"
                           class="block w-full rounded-xl border @error('author') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                           required>
                    @error('author')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun -->
                <div>
                    <label for="year" class="block text-sm font-medium text-slate-700 mb-1">Tahun</label>
                    <input type="number" wire:model="year" id="year"
                           class="block w-full rounded-xl border @error('year') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                           required>
                    @error('year')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar Cover -->
                <div>
                    <label for="cover_image_path" class="block text-sm font-medium text-slate-700 mb-1">Gambar Cover</label>
                    <input type="file" wire:model="cover_image_path" id="cover_image_path"
                           class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"
                           accept="image/jpg,image/jpeg,image/png">
                    
                    <!-- Preview untuk file baru -->
                    @if ($cover_image_path)
                        <div class="mt-3 flex items-center gap-3">
                            <img src="{{ $cover_image_path->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-lg shadow-md">
                            <button type="button" wire:click="removeCover" class="text-red-600 hover:text-red-700 text-sm">
                                Hapus
                            </button>
                        </div>
                    @endif
                    
                    <!-- Info file existing -->
                    @if ($existingCover && !$cover_image_path)
                        <p class="mt-2 text-sm text-slate-600">
                            Gambar saat ini: 
                            <a href="{{ asset('storage/' . $existingCover) }}" target="_blank"
                               class="text-sky-600 hover:underline">Lihat Cover</a>
                        </p>
                    @endif
                    
                    @error('cover_image_path')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Ebook (ZIP) -->
                <div>
                    <label for="ebook_file_path" class="block text-sm font-medium text-slate-700 mb-1">
                        File Ebook (HTML/ZIP) {{ !$isEdit ? '*' : '' }}
                    </label>
                    <input type="file" wire:model="ebook_file_path" id="ebook_file_path"
                           class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"
                           accept=".zip">
                    
                    @if ($ebook_file_path)
                        <div class="mt-2 flex items-center gap-3">
                            <span class="text-sm text-slate-600">{{ $ebook_file_path->getClientOriginalName() }}</span>
                            <button type="button" wire:click="removeEbookFile" class="text-red-600 hover:text-red-700 text-sm">
                                Hapus
                            </button>
                        </div>
                    @endif
                    
                    @if ($existingEbookFile && !$ebook_file_path)
                        <p class="mt-2 text-sm text-slate-600">
                            File saat ini:
                            <a href="{{ asset('storage/' . $existingEbookFile) }}" target="_blank"
                               class="text-sky-600 hover:underline">Lihat File</a>
                        </p>
                    @endif
                    
                    @error('ebook_file_path')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Download (EPUB/PDF) -->
                <div>
                    <label for="download_path" class="block text-sm font-medium text-slate-700 mb-1">
                        File Download (EPUB/PDF) {{ !$isEdit ? '*' : '' }}
                    </label>
                    <input type="file" wire:model="download_path" id="download_path"
                           class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"
                           accept=".epub,.pdf">
                    
                    @if ($download_path)
                        <div class="mt-2 flex items-center gap-3">
                            <span class="text-sm text-slate-600">{{ $download_path->getClientOriginalName() }}</span>
                            <button type="button" wire:click="removeDownloadFile" class="text-red-600 hover:text-red-700 text-sm">
                                Hapus
                            </button>
                        </div>
                    @endif
                    
                    @if ($existingDownloadFile && !$download_path)
                        <p class="mt-2 text-sm text-slate-600">
                            File saat ini:
                            <a href="{{ asset('storage/' . $existingDownloadFile) }}" target="_blank"
                               class="text-sky-600 hover:underline">Unduh File</a>
                        </p>
                    @endif
                    
                    @error('download_path')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                    <select wire:model="category_id" id="category_id"
                            class="block w-full rounded-xl border @error('category_id') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none">
                        <option value="">Tanpa Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea wire:model="description" id="description" rows="4"
                              class="block w-full rounded-xl border @error('description') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none resize-none"
                              placeholder="Tulis deskripsi singkat tentang ebook..."></textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-3 pt-4">
                    <button type="submit"
                            class="px-5 py-2.5 bg-sky-600 text-white text-sm font-medium rounded-xl hover:bg-sky-700 focus:ring-2 focus:ring-sky-400 focus:outline-none transition">
                        {{ $isEdit ? 'Perbarui' : 'Simpan' }}
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