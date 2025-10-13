@extends('layouts.app')

@section('content')
    <x-navbar />
    <div class="flex">
        <x-sidebar />

        <div class="flex-1">
            <x-global-notification />
            @isset($ebook)
                <!-- Untuk edit - pass ebook data -->
                <livewire:ebook-form :ebook="$ebook" />
            @else
                <!-- Untuk create - tanpa parameter -->
                <livewire:ebook-form />
            @endisset
        </div>
    </div>
@endsection