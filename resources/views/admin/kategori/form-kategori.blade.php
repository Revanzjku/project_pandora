@extends('layouts.app')

@section('content')
    <x-navbar />
    <div class="flex">
        <x-sidebar />

        <!-- Main Content -->
        <div class="flex-1">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <x-global-notification />
                @isset($category)
                    <livewire:kategori-form :category="$category" />
                @else
                    <livewire:kategori-form />
                @endisset
            </div>
        </div>
    </div>
@endsection