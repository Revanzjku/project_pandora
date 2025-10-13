@extends('layouts.app')
@section('content')
    <x-navbar />
        <div class="flex">
            <x-sidebar />

            <!-- Main Content -->
            <div class="flex-1 lg:ml-0">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <!-- Welcome Section -->
                    <div class="mb-8">
                        <h1 class="heading text-2xl sm:text-3xl font-bold text-slate-900 mb-2">
                            Halo, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-slate-600">
                            Selamat datang di dashboard admin. Kelola sistem PANDORA dengan mudah.
                        </p>
                    </div>

                    <!-- Statistics Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Admin Statistics -->
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Total Ebook</p>
                                    <p class="text-2xl font-bold text-slate-900">{{ number_format($totalEbooks) }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-cyan-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Total Pengguna</p>
                                    <p class="text-2xl font-bold text-slate-900">{{ number_format($totalUsers) }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Download Hari Ini</p>
                                    <p class="text-2xl font-bold text-slate-900">{{ number_format($todayDownloads) }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Aktivitas Hari Ini</p>
                                    <p class="text-2xl font-bold text-slate-900">{{ number_format($todayActivities) }}</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-red-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Registration Statistics Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <!-- Monthly Registration Chart -->
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h2 class="text-xl font-bold text-slate-900">Registrasi Pengguna Bulanan</h2>
                                    <p class="text-sm text-slate-600 mt-1">Data registrasi 12 bulan terakhir</p>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <div class="w-3 h-3 bg-sky-500 rounded-full"></div>
                                    <span class="text-slate-600">Pengguna Baru</span>
                                </div>
                            </div>
                            
                            <!-- Chart Container -->
                            <div class="relative h-80">
                                <canvas id="userRegistrationChart" class="w-full h-full"></canvas>
                            </div>
                        </div>

                        <!-- Registration Summary -->
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <h2 class="text-xl font-bold text-slate-900 mb-6">Ringkasan Statistik</h2>
                            
                            <div class="space-y-6">
                                <!-- This Month -->
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-sky-50 to-cyan-50 rounded-xl">
                                    <div>
                                        <p class="text-sm font-medium text-slate-600">Bulan Ini</p>
                                        <p class="text-2xl font-bold text-slate-900">{{ number_format($currentMonthCount) }}</p>
                                        <p class="text-xs {{ $monthlyGrowth >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                                            {{ $monthlyGrowth >= 0 ? '↑' : '↓' }} {{ abs($monthlyGrowth) }}% dari bulan lalu
                                        </p>
                                    </div>
                                    <div class="w-12 h-12 rounded-xl bg-sky-100 grid place-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Average per Month -->
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl">
                                    <div>
                                        <p class="text-sm font-medium text-slate-600">Rata-rata per Bulan</p>
                                        <p class="text-2xl font-bold text-slate-900">{{ number_format($averageMonthlyCount) }}</p>
                                        <p class="text-xs text-slate-500">Dalam 12 bulan terakhir</p>
                                    </div>
                                    <div class="w-12 h-12 rounded-xl bg-emerald-100 grid place-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Peak Month -->
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl">
                                    <div>
                                        <p class="text-sm font-medium text-slate-600">Bulan Tertinggi</p>
                                        <p class="text-2xl font-bold text-slate-900">{{ number_format($peakMonthCount ?? 0) }}</p>
                                        <p class="text-xs text-slate-500">{{ $peakMonthName }}</p>
                                    </div>
                                    <div class="w-12 h-12 rounded-xl bg-indigo-100 grid place-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                        </svg>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Chart.js Script -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
        <script>
            // User Registration Chart
            const ctx = document.getElementById('userRegistrationChart').getContext('2d');
            
            // Dynamic data from backend
            const monthlyData = {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Pengguna Baru',
                    data: @json($chartData),
                    borderColor: 'rgb(14, 165, 233)',
                    backgroundColor: 'rgba(14, 165, 233, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(14, 165, 233)',
                    pointBorderColor: 'white',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            };

            const config = {
                type: 'line',
                data: monthlyData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(14, 165, 233, 0.8)',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.y} pengguna baru`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                borderDash: [5, 5]
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    size: 12
                                },
                                callback: function(value) {
                                    return value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            };

            new Chart(ctx, config);
        </script>
@endsection