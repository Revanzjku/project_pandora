<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrustTunnelingDomains
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya aktif di environment local/development
        if (app()->environment('local', 'development', 'testing')) {
            $this->configureForTunneling($request);
        }

        return $next($request);
    }

    /**
     * Configure session settings for tunneling services
     */
    private function configureForTunneling(Request $request): void
    {
        $host = $request->getHost();
        
        // Daftar domain tunneling yang dikenal
        $tunnelingDomains = [
            'ngrok.io',
            'ngrok-free.app', 
            'ngrok.app',
            'expose.sh',
            'localtunnel.me',
            'serveo.net',
            'tunnelto.dev',
            'localhost.run'
        ];
        
        // Cek apakah request berasal dari tunneling service
        $isTunneling = false;
        foreach ($tunnelingDomains as $domain) {
            if (str_contains($host, $domain)) {
                $isTunneling = true;
                break;
            }
        }
        
        // Jika menggunakan tunneling, sesuaikan konfigurasi session
        if ($isTunneling) {
            // Set secure cookie ke false untuk HTTP tunneling
            config(['session.secure' => false]);
            
            // Set same_site ke 'none' untuk cross-origin requests
            config(['session.same_site' => 'none']);
            
            // Set domain ke null untuk menghindari domain mismatch
            config(['session.domain' => null]);
            
            // Log untuk debugging (opsional)
            if (config('app.debug')) {
                \Log::info('Tunneling detected, session config adjusted', [
                    'host' => $host,
                    'secure' => false,
                    'same_site' => 'none'
                ]);
            }
        }
    }
}
