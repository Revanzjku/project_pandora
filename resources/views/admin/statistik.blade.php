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
                            Statistik Pengunjung 📊
                        </h1>
                        <p class="text-slate-600">
                            Pantau aktivitas dan engagement pengguna pada sistem PANDORA.
                        </p>
                    </div>

                    <!-- Statistics Cards Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Books Read -->
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Buku Dibaca</p>
                                    <p class="text-2xl font-bold text-slate-900" id="books-read-count">3,542</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Books Downloaded -->
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Buku Didownload</p>
                                    <p class="text-2xl font-bold text-slate-900" id="books-downloaded-count">1,847</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Book Quotes -->
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Kutipan Diambil</p>
                                    <p class="text-2xl font-bold text-slate-900" id="quotes-taken-count">926</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Registered Users -->
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600">Pengguna Terdaftar</p>
                                    <p class="text-2xl font-bold text-slate-900" id="registered-users-count">2,341</p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-red-600 grid place-items-center text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <!-- Bar Chart -->
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="mb-6">
                                <h3 class="text-lg font-bold text-slate-900">Statistik Aktivitas</h3>
                                <p class="text-sm text-slate-600">Data aktivitas pengguna dalam bentuk bar chart</p>
                            </div>
                            <div class="relative h-80">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>

                        <!-- Doughnut Chart -->
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                            <div class="mb-6">
                                <h3 class="text-lg font-bold text-slate-900">Distribusi Aktivitas</h3>
                                <p class="text-sm text-slate-600">Persentase aktivitas pengguna</p>
                            </div>
                            <div class="relative h-80">
                                <canvas id="doughnutChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Line Chart - Full Width -->
                    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6 mb-8">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-slate-900">Tren Aktivitas Bulanan</h3>
                            <p class="text-sm text-slate-600">Grafik perkembangan aktivitas selama 12 bulan terakhir</p>
                        </div>
                        <div class="relative h-96">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>

                    <!-- Time Period Selector -->
                    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200/60 p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">Filter Periode</h3>
                                <p class="text-sm text-slate-600">Pilih periode untuk melihat statistik</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-sm font-medium text-slate-700 transition-colors duration-200" onclick="updatePeriod('7days')">
                                    7 Hari
                                </button>
                                <button class="px-4 py-2 bg-sky-100 text-sky-700 rounded-lg text-sm font-medium transition-colors duration-200" onclick="updatePeriod('30days')">
                                    30 Hari
                                </button>
                                <button class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-sm font-medium text-slate-700 transition-colors duration-200" onclick="updatePeriod('3months')">
                                    3 Bulan
                                </button>
                                <button class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-sm font-medium text-slate-700 transition-colors duration-200" onclick="updatePeriod('1year')">
                                    1 Tahun
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <!-- Chart.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
    <script>
        // Sample data - replace with actual data from your backend
        const statisticsData = {
            booksRead: 3542,
            booksDownloaded: 1847,
            quotesTaken: 926,
            registeredUsers: 2341
        };

        // Chart configurations
        const chartColors = {
            blue: 'rgba(59, 130, 246, 0.8)',
            green: 'rgba(34, 197, 94, 0.8)',
            purple: 'rgba(168, 85, 247, 0.8)',
            orange: 'rgba(249, 115, 22, 0.8)',
            blueBorder: 'rgba(59, 130, 246, 1)',
            greenBorder: 'rgba(34, 197, 94, 1)',
            purpleBorder: 'rgba(168, 85, 247, 1)',
            orangeBorder: 'rgba(249, 115, 22, 1)'
        };

        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Buku Dibaca', 'Buku Didownload', 'Kutipan Diambil', 'Pengguna Terdaftar'],
                datasets: [{
                    label: 'Jumlah',
                    data: [statisticsData.booksRead, statisticsData.booksDownloaded, statisticsData.quotesTaken, statisticsData.registeredUsers],
                    backgroundColor: [chartColors.blue, chartColors.green, chartColors.purple, chartColors.orange],
                    borderColor: [chartColors.blueBorder, chartColors.greenBorder, chartColors.purpleBorder, chartColors.orangeBorder],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Doughnut Chart
        const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
        const doughnutChart = new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Buku Dibaca', 'Buku Didownload', 'Kutipan Diambil', 'Pengguna Terdaftar'],
                datasets: [{
                    data: [statisticsData.booksRead, statisticsData.booksDownloaded, statisticsData.quotesTaken, statisticsData.registeredUsers],
                    backgroundColor: [chartColors.blue, chartColors.green, chartColors.purple, chartColors.orange],
                    borderColor: [chartColors.blueBorder, chartColors.greenBorder, chartColors.purpleBorder, chartColors.orangeBorder],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Line Chart - Monthly Trend
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const monthlyData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [
                {
                    label: 'Buku Dibaca',
                    data: [120, 190, 300, 500, 200, 300, 450, 390, 420, 380, 290, 350],
                    borderColor: chartColors.blueBorder,
                    backgroundColor: chartColors.blue,
                    tension: 0.4,
                    fill: false
                },
                {
                    label: 'Buku Didownload',
                    data: [80, 120, 180, 250, 150, 200, 280, 220, 240, 210, 180, 220],
                    borderColor: chartColors.greenBorder,
                    backgroundColor: chartColors.green,
                    tension: 0.4,
                    fill: false
                },
                {
                    label: 'Kutipan Diambil',
                    data: [40, 60, 90, 120, 75, 95, 140, 110, 120, 105, 85, 110],
                    borderColor: chartColors.purpleBorder,
                    backgroundColor: chartColors.purple,
                    tension: 0.4,
                    fill: false
                },
                {
                    label: 'Pengguna Baru',
                    data: [25, 35, 45, 65, 40, 50, 70, 55, 60, 52, 42, 55],
                    borderColor: chartColors.orangeBorder,
                    backgroundColor: chartColors.orange,
                    tension: 0.4,
                    fill: false
                }
            ]
        };

        const lineChart = new Chart(lineCtx, {
            type: 'line',
            data: monthlyData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)'
                        }
                    }
                }
            }
        });

        // Function to update period (you can implement this to fetch different data)
        function updatePeriod(period) {
            // Remove active class from all buttons
            document.querySelectorAll('[onclick*="updatePeriod"]').forEach(btn => {
                btn.className = btn.className.replace('bg-sky-100 text-sky-700', 'bg-slate-100 hover:bg-slate-200 text-slate-700');
            });
            
            // Add active class to clicked button
            event.target.className = 'px-4 py-2 bg-sky-100 text-sky-700 rounded-lg text-sm font-medium transition-colors duration-200';
            
            // Here you would typically fetch new data based on the selected period
            // and update the charts accordingly
            console.log('Period updated to:', period);
        }
    </script>
@endsection