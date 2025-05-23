<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Sales Metrics
        $todaySale = Sale::whereDate('sale_date', Carbon::today())->sum('total_amount');
        $yesterdaySale = Sale::whereDate('sale_date', Carbon::yesterday())->sum('total_amount');
        $thisWeekSale = Sale::whereBetween('sale_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_amount');
        $previousWeekSale = Sale::whereBetween('sale_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->sum('total_amount');
        $thisMonthSale = Sale::whereMonth('sale_date', Carbon::now()->month)->whereYear('sale_date', Carbon::now()->year)->sum('total_amount');
        $previousMonthSale = Sale::whereMonth('sale_date', Carbon::now()->subMonth()->month)->whereYear('sale_date', Carbon::now()->subMonth()->year)->sum('total_amount');
        $thisYearSale = Sale::whereYear('sale_date', Carbon::now()->year)->sum('total_amount');
        $previousYearSale = Sale::whereYear('sale_date', Carbon::now()->subYear()->year)->sum('total_amount');
        $totalSales = Sale::sum('total_amount');

        // Stock Metrics
        $stockValue = Medicine::sum(DB::raw('stock_quantity * selling_price'));
        $lowStockCount = Medicine::where('stock_quantity', '<', 10)->count();
        $expiringSoon = Medicine::where('expiry_date', '<=', now()->addDays(30))
            ->where('expiry_date', '>=', now())
            ->count();

        // Payment Metric
        $pendingPayments = Sale::sum('due_amount');

        // Recent Activity
        $recentPurchases = Purchase::with('supplier')
            ->orderBy('purchase_date', 'desc')
            ->take(5)
            ->get();
        $recentSales = Sale::with('user')
            ->orderBy('sale_date', 'desc')
            ->take(5)
            ->get();

        // Available years for filter
        $minYear = Sale::min(DB::raw('YEAR(sale_date)')) ?? date('Y');
        $years = range($minYear, date('Y'));

        return view('admin.home', compact(
            'todaySale', 'yesterdaySale', 'thisWeekSale', 'previousWeekSale',
            'thisMonthSale', 'previousMonthSale', 'thisYearSale', 'previousYearSale',
            'totalSales', 'stockValue', 'lowStockCount', 'expiringSoon', 'pendingPayments',
            'recentPurchases', 'recentSales', 'years'
        ));
    }

    public function getChartData(Request $request)
    {
        $year = $request->input('year', date('Y'));

        // Monthly Sales for the selected year
        $monthlySales = Sale::select(
            DB::raw('MONTH(sale_date) as month'),
            DB::raw('COALESCE(SUM(total_amount), 0) as total')
        )
            ->whereYear('sale_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $salesData = [];
        $salesLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        for ($month = 1; $month <= 12; $month++) {
            $salesData[] = isset($monthlySales[$month]) ? round($monthlySales[$month]->total, 2) : 0;
        }

        // Stock by Category
        $stockByCategory = Category::with('medicines')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'stock' => $category->medicines->sum('stock_quantity')
                ];
            })
            ->filter(function ($item) {
                return $item['stock'] > 0;
            });

        $categoryLabels = $stockByCategory->pluck('name')->toArray();
        $categoryData = $stockByCategory->pluck('stock')->toArray();

        // Top 5 Best-Selling Medicines
        $topMedicines = Medicine::join('sale_details', 'medicines.id', '=', 'sale_details.medicine_id')
            ->select(
                'medicines.name',
                DB::raw('SUM(sale_details.quantity) as total_quantity')
            )
            ->groupBy('medicines.id', 'medicines.name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        $medicineLabels = $topMedicines->pluck('name')->toArray();
        $medicineData = $topMedicines->pluck('total_quantity')->toArray();

        return response()->json([
            'monthlySales' => ['labels' => $salesLabels, 'data' => $salesData],
            'stockByCategory' => ['labels' => $categoryLabels, 'data' => $categoryData],
            'topMedicines' => ['labels' => $medicineLabels, 'data' => $medicineData]
        ]);
    }
}
