<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Pembelians;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $todaySales = Pembelians::whereDate('created_at', today())->count();
        $totalPembelian = Pembelians::count();
        // $members = Member::where('name');
        $totalMember = Member::count();
        $totalProduk = Product::count();
        $totalKeuntungan = Pembelians::sum('grand_total');
    
        // Data pembelian harian (30 hari terakhir)
        $dailySales = Pembelians::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    
        // Data pembelian per produk
        $productSales = DB::table('pembelian_details')
            ->join('products', 'pembelian_details.id_produk', '=', 'products.id')
            ->select('products.nama_produk', DB::raw('SUM(pembelian_details.quantity) as total_sold'))
            ->groupBy('products.nama_produk')
            ->orderByDesc('total_sold')
            ->get();
    
        // Prepare data for pie chart
// Prepare data for pie chart
$nama_produk = $productSales->pluck('nama_produk')->toArray();
$total_penjualan = $productSales->sum('total_sold');
$productPercentages = $productSales->map(function($item) use ($total_penjualan) {
    return $total_penjualan > 0 ? round(($item->total_sold / $total_penjualan) * 100, 1) : 0;
})->toArray();

$colors = [
    'rgba(255, 99, 132, 0.8)',
    'rgba(54, 162, 235, 0.8)',
    'rgba(255, 206, 86, 0.8)',
    'rgba(75, 192, 192, 0.8)',
    'rgba(153, 102, 255, 0.8)',
    'rgba(255, 159, 64, 0.8)',
    'rgba(255, 99, 255, 0.8)',
    'rgba(54, 162, 64, 0.8)',
    'rgba(255, 206, 192, 0.8)',
    'rgba(75, 192, 255, 0.8)'
];

// Extract the actual sales (total sold) into a separate variable
$actualData = $productSales->pluck('total_sold')->toArray();

return view('dashboard', compact(
    'todaySales', 
    'dailySales', 
    'productSales',
    'nama_produk',
    'productPercentages',
    'colors',
    'actualData',
    'totalPembelian',
    'totalMember',
    'totalProduk',
    'totalKeuntungan',
));
    }

    public function getStats(Request $request)
    {
        $period = $request->input('period', 'day');
        $query = Pembelians::query();
        $now = now();

        switch ($period) {
            case 'week':
                $query->whereDate('created_at', '>=', $now->startOfWeek())
                      ->whereDate('created_at', '<=', $now->endOfWeek());
                break;
            case 'month':
                $query->whereMonth('created_at', $now->month)
                      ->whereYear('created_at', $now->year);
                break;
            case 'year':
                $query->whereYear('created_at', $now->year);
                break;
            default: // day
                $query->whereDate('created_at', today());
                break;
        }

        $totalPembelian = $query->count();
        $totalKeuntungan = $query->sum('grand_total');
        $totalMember = Member::count();
        $totalProduk = Product::count();

        // Data pembelian harian untuk grafik
        $dailySales = $query->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Data pembelian per produk untuk pie chart
        $productSales = DB::table('pembelian_details')
            ->join('products', 'pembelian_details.id_produk', '=', 'id_produk')
            ->join('pembelians', 'pembelian_details.id_pembelian', '=', 'pembelians.id')
            ->whereBetween('pembelians.created_at', [$query->getQuery()->wheres[0]['value'], $now])
            ->select('products.nama_produk', DB::raw('SUM(pembelian_details.quantity) as total_sold'))
            ->groupBy('products.nama_produk')
            ->orderByDesc('total_sold')
            ->get();

        return response()->json([
            'totalPembelian' => $totalPembelian,
            'totalMember' => $totalMember,
            'totalProduk' => $totalProduk,
            'totalKeuntungan' => $totalKeuntungan,
            'dailySales' => $dailySales,
            'productSales' => $productSales
        ]);
    }

    }