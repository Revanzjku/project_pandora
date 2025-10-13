<!-- Global Notification Component -->
<div x-data="{
    show: false,
    message: '',
    type: '',
    init() {
        // Listen untuk event dari Livewire (dalam halaman yang sama)
        window.addEventListener('showNotification', (e) => {
            this.showNotification(e.detail.type, e.detail.message);
        });
        
        // Check for session notification (setelah redirect)
        @if(session('notification'))
            this.showNotification('{{ session('notification.type') }}', '{{ session('notification.message') }}');
        @endif
        
        // Juga listen untuk event show-notification (backup)
        window.addEventListener('show-notification', (e) => {
            this.showNotification(e.detail.type, e.detail.message);
        });
    },
    showNotification(type, message) {
        this.show = true;
        this.type = type;
        this.message = message;
        
        // Auto hide setelah 3 detik
        setTimeout(() => {
            this.show = false;
        }, 3000);
    }
}" 
x-show="show" 
x-cloak
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0 transform translate-y-2"
x-transition:enter-end="opacity-100 transform translate-y-0"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100 transform translate-y-0"
x-transition:leave-end="opacity-0 transform translate-y-2"
class="fixed top-4 right-4 z-50 max-w-sm w-full">
    <div x-show="show"
         :class="{
            'bg-green-50 border-green-200 text-green-700': type === 'success',
            'bg-red-50 border-red-200 text-red-700': type === 'error',
            'bg-blue-50 border-blue-200 text-blue-700': !type
         }"
         class="rounded-lg border px-4 py-3 text-sm shadow-lg">
        <div class="flex items-center justify-between">
            <span x-text="message"></span>
            <button @click="show = false" class="ml-4 text-current hover:opacity-70">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</div>