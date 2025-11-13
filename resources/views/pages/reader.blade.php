@extends('layouts.app')

@section('content')

    <div class="flex flex-col h-screen">
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200 bg-white shadow-sm">
            <h1 class="text-lg font-semibold text-slate-800 truncate">
                {{ $ebook->title }}
            </h1>
            <div class="flex items-center space-x-2">
                <a href="{{ session('reader_referrer', route('katalog')) }}" 
                   class="px-3 py-2 text-sm rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200">
                    ← Kembali
                </a>
            </div>
        </div>

        <!-- Reader -->
        <div class="flex-1 overflow-hidden bg-slate-50 flex flex-col">
            <div id="readerWrapper" class="flex-1 w-full overflow-auto relative">
                <iframe id="readerIframe" src="{{ asset('storage/' . $ebook->ebook_file_path) }}" 
                        class="w-full h-full border-0" 
                        title="Ebook Reader"></iframe>
            </div>
        </div>
    </div>
    
    {{-- Small script to attempt scaling inner HTML (only works same-origin) --}}
    <script>
        (function(){
            const iframe = document.getElementById('readerIframe');
            const wrapper = document.getElementById('readerWrapper');

            function tryAdjustScale(){
                try{
                    const doc = iframe.contentDocument || iframe.contentWindow.document;
                    if(!doc) return;

                    // get content width and wrapper width
                    const contentWidth = doc.documentElement.scrollWidth || doc.body.scrollWidth;
                    const containerWidth = wrapper.clientWidth;

                    if(!contentWidth || !containerWidth) return;

                    const scale = containerWidth / contentWidth;

                    if(scale < 1){
                        doc.body.style.transform = 'scale(' + scale + ')';
                        doc.body.style.transformOrigin = '0 0';
                        // ensure height fits by increasing width of root to compensate
                        doc.documentElement.style.width = (100/scale) + '%';
                    } else {
                        doc.body.style.transform = '';
                        doc.body.style.transformOrigin = '';
                        doc.documentElement.style.width = '';
                    }
                }catch(e){
                    // cross-origin or other issue - silently fail
                    // console.debug('Could not auto-scale iframe content', e);
                }
            }

            // Attempt adjust on load and resize
            iframe.addEventListener('load', function(){
                tryAdjustScale();
                // also try again after a short delay for resources
                setTimeout(tryAdjustScale, 400);
            });

            window.addEventListener('resize', function(){
                tryAdjustScale();
            });
        })();
    </script>
@endsection