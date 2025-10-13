<div>
    <!-- Page Header -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-slate-900">
            {{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
        </h1>
        <p class="mt-1 text-slate-600">
            {{ $isEdit ? 'Perbarui data kategori yang ada.' : 'Tambahkan kategori baru ke sistem.' }}
        </p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-lg ring-1 ring-slate-200/70 p-8 transition hover:shadow-xl">
        <form wire:submit="save" class="space-y-6">
            <!-- Nama Kategori -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori</label>
                <input type="text" wire:model="name" id="name"
                    class="block w-full rounded-xl border @error('name') border-red-500 @else border-slate-300 @enderror bg-slate-50 px-4 py-2 text-sm shadow-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500 focus:outline-none"
                    placeholder="Masukkan nama kategori"
                    required>
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="flex items-center space-x-3 pt-4">
                <button type="submit"
                    class="px-5 py-2.5 bg-sky-600 text-white text-sm font-medium rounded-xl hover:bg-sky-700 focus:ring-2 focus:ring-sky-400 focus:outline-none transition disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        {{ $isEdit ? 'Perbarui' : 'Simpan' }}
                    </span>
                    <span wire:loading>
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
                <a href="{{ route('admin.categories.index') }}"
                    class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>