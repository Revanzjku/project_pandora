<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Ebook;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Admin';
        // Total Statistics
        $totalEbooks = Ebook::count();
        $totalUsers = User::count();
        $todayDownloads = LogActivity::where('activity_type', 'download')
            ->whereDate('created_at', today())
            ->count();
        $todayActivities = LogActivity::whereDate('created_at', today())->count();

        // Monthly User Registration Data (12 bulan terakhir)
        $monthlyRegistrations = User::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Format data untuk chart
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthYear = $date->format('M Y');
            $chartLabels[] = $date->format('M');
            
            $registration = $monthlyRegistrations->first(function ($item) use ($date) {
                return $item->year == $date->year && $item->month == $date->month;
            });
            
            $chartData[] = $registration ? $registration->count : 0;
        }

        // Registration Summary
        $currentMonthCount = User::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $lastMonthCount = User::whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();

        $monthlyGrowth = $lastMonthCount > 0 
            ? round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100, 1)
            : 0;

        $averageMonthly = User::where('created_at', '>=', now()->subMonths(12))
            ->select(DB::raw('COUNT(*) as total'), DB::raw('COUNT(DISTINCT YEAR(created_at), MONTH(created_at)) as months'))
            ->first();
        
        $averageMonthlyCount = $averageMonthly->months > 0 
            ? round($averageMonthly->total / $averageMonthly->months) 
            : 0;

        $peakMonth = User::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('count', 'desc')
            ->first();

        // Perbaikan: Definisikan peakMonthCount
        $peakMonthCount = $peakMonth ? $peakMonth->count : 0;
        $peakMonthName = $peakMonth 
            ? Carbon::create($peakMonth->year, $peakMonth->month)->translatedFormat('F Y')
            : '-';

        return view('pages.dashboard', compact(
            'title',
            'totalEbooks',
            'totalUsers',
            'todayDownloads',
            'todayActivities',
            'chartLabels',
            'chartData',
            'currentMonthCount',
            'monthlyGrowth',
            'averageMonthlyCount',
            'peakMonthCount', // Sekarang sudah didefinisikan
            'peakMonthName'
        ));
    }
}