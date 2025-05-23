@extends('admin.master')

@section('content')
    <div class="page-wrapper" style="background-color: #F5F7FA;">
        <div class="page-content py-4">
            <div class="container-fluid">
                <!-- Metric Cards -->
                <div class="row g-3 mb-5">
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #0288D1; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0288D1, #4FC3F7); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-dollar-sign text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">Today’s Sale</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">${{ number_format($todaySale, 2) }}</h4>
                                <p class="mb-0" style="color: #0288D1; font-size: 0.75rem;">
                                    @php
                                        $change = $yesterdaySale > 0 ? (($todaySale - $yesterdaySale) / $yesterdaySale) * 100 : 0;
                                        $icon = $change >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                                        $color = $change >= 0 ? '#0288D1' : '#D32F2F';
                                    @endphp
                                    {{ number_format($change, 1) }}% from yesterday <i class="fas {{ $icon }} ml-1" style="color: {{ $color }};"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #0288D1; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0288D1, #4FC3F7); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-dollar-sign text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">Yesterday’s Sale</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">${{ number_format($yesterdaySale, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #0288D1; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0288D1, #4FC3F7); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-calendar-week text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">This Week Sale</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">${{ number_format($thisWeekSale, 2) }}</h4>
                                <p class="mb-0" style="color: #0288D1; font-size: 0.75rem;">
                                    @php
                                        $change = $previousWeekSale > 0 ? (($thisWeekSale - $previousWeekSale) / $previousWeekSale) * 100 : 0;
                                        $icon = $change >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                                        $color = $change >= 0 ? '#0288D1' : '#D32F2F';
                                    @endphp
                                    {{ number_format($change, 1) }}% from last week <i class="fas {{ $icon }} ml-1" style="color: {{ $color }};"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #0288D1; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0288D1, #4FC3F7); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-calendar-week text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">Previous Week Sale</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">${{ number_format($previousWeekSale, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #0288D1; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0288D1, #4FC3F7); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-calendar-alt text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">This Month Sale</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">${{ number_format($thisMonthSale, 2) }}</h4>
                                <p class="mb-0" style="color: #0288D1; font-size: 0.75rem;">
                                    @php
                                        $change = $previousMonthSale > 0 ? (($thisMonthSale - $previousMonthSale) / $previousMonthSale) * 100 : 0;
                                        $icon = $change >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                                        $color = $change >= 0 ? '#0288D1' : '#D32F2F';
                                    @endphp
                                    {{ number_format($change, 1) }}% from last month <i class="fas {{ $icon }} ml-1" style="color: {{ $color }};"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #0288D1; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0288D1, #4FC3F7); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-calendar-alt text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">Previous Month Sale</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">${{ number_format($previousMonthSale, 2) }}</h4>
                                <p class="mb-0" style="color: #0288D1; font-size: 0.75rem;">N/A <i class="fas fa-equals ml-1" style="color: #0288D1;"></i></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #0288D1; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0288D1, #4FC3F7); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-calendar text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">This Year Sale</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">${{ number_format($thisYearSale, 2) }}</h4>
                                <p class="mb-0" style="color: #0288D1; font-size: 0.75rem;">
                                    @php
                                        $change = $previousYearSale > 0 ? (($thisYearSale - $previousYearSale) / $previousYearSale) * 100 : 0;
                                        $icon = $change >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                                        $color = $change >= 0 ? '#0288D1' : '#D32F2F';
                                    @endphp
                                    {{ number_format($change, 1) }}% from last year <i class="fas {{ $icon }} ml-1" style="color: {{ $color }};"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #0288D1; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0288D1, #4FC3F7); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-calendar text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">Previous Year Sale</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">${{ number_format($previousYearSale, 2) }}</h4>
                                <p class="mb-0" style="color: #0288D1; font-size: 0.75rem;">N/A <i class="fas fa-equals ml-1" style="color: #0288D1;"></i></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #0288D1; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0288D1, #4FC3F7); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-money-bill-wave text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">Total Sales</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">${{ number_format($totalSales, 2) }}</h4>
                                <p class="mb-0" style="color: #0288D1; font-size: 0.75rem;">N/A <i class="fas fa-equals ml-1" style="color: #0288D1;"></i></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #2E7D32; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #2E7D32, #4CAF50); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-boxes text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">Stock Value</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">${{ number_format($stockValue, 2) }}</h4>
                                <p class="mb-0" style="color: #2E7D32; font-size: 0.75rem;">-2.0% from yesterday <i class="fas fa-arrow-down ml-1" style="color: #2E7D32;"></i></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #D32F2F; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #D32F2F, #EF5350); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-exclamation-triangle text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">Low Stock Items</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">{{ $lowStockCount }}</h4>
                                <p class="mb-0" style="color: #D32F2F; font-size: 0.75rem;">+0% from yesterday <i class="fas fa-equals ml-1" style="color: #D32F2F;"></i></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #FBBF24; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FBBF24, #FFD54F); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-clock text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">Expiring Soon</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">{{ $expiringSoon }}</h4>
                                <p class="mb-0" style="color: #FBBF24; font-size: 0.75rem;">+0% from yesterday <i class="fas fa-equals ml-1" style="color: #FBBF24;"></i></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-12">
                        <div class="card border-0 shadow-sm metric-card" style="border-radius: 12px; min-height: 120px; background: #FFFFFF; border-left: 4px solid #34D399; transition: transform 0.2s ease;">
                            <div class="card-body p-3 text-center">
                                <div class="icon-circle mb-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #34D399, #6EE7B7); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-money-bill text-white" style="font-size: 1rem;"></i>
                                </div>
                                <h6 class="mb-1" style="color: #757575; font-size: 0.9rem;">Pending Payments</h6>
                                <h4 class="fw-bold mb-1" style="color: #212121; font-size: 1.2rem;">${{ number_format($pendingPayments, 2) }}</h4>
                                <p class="mb-0" style="color: #34D399; font-size: 0.75rem;">
                                    @php
                                        $change = $pendingPayments > 0 ? (($pendingPayments - ($pendingPayments * 0.99)) / ($pendingPayments * 0.99)) * 100 : 0; // Simulated -1% change
                                        $icon = $change >= 0 ? 'fa-arrow-up' : 'fa-arrow-down';
                                        $color = $change >= 0 ? '#34D399' : '#D32F2F';
                                    @endphp
                                    {{ number_format($change, 1) }}% from yesterday <i class="fas {{ $icon }} ml-1" style="color: {{ $color }};"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="row g-4 mb-5">
                    <!-- Monthly Sales Line Chart -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-header py-3 border-0" style="background: linear-gradient(135deg, #2E7D32, #4CAF50); border-radius: 12px 12px 0 0;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-white"><i class="fas fa-chart-line me-2"></i>Monthly Sales Trend</h5>
                                    <select id="yearFilter" class="form-select form-select-sm" style="width: 120px; border-radius: 8px;">
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div id="monthlySalesChart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Stock by Category Pie Chart -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-header py-3 border-0" style="background: linear-gradient(135deg, #0288D1, #4FC3F7); border-radius: 12px 12px 0 0;">
                                <h5 class="mb-0 text-white"><i class="fas fa-chart-pie me-2"></i>Stock by Category</h5>
                            </div>
                            <div class="card-body p-4">
                                <div id="stockByCategoryChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mb-5">
                    <!-- Top Medicines Bar Chart -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-header py-3 border-0" style="background: linear-gradient(135deg, #2E7D32, #4CAF50); border-radius: 12px 12px 0 0;">
                                <h5 class="mb-0 text-white"><i class="fas fa-chart-bar me-2"></i>Top 5 Best-Selling Medicines</h5>
                            </div>
                            <div class="card-body p-4">
                                <div id="topMedicinesChart"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row g-4">
                    <!-- Recent Purchases -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-header py-3 border-0" style="background: linear-gradient(135deg, #0288D1, #4FC3F7); border-radius: 12px 12px 0 0;">
                                <h5 class="mb-0 text-white"><i class="fas fa-shopping-cart me-2"></i>Recent Purchases</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" style="border-radius: 0 0 12px 12px;">
                                        <thead style="background-color: #0288D1; color: white;">
                                            <tr>
                                                <th>Purchase Code</th>
                                                <th>Supplier</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($recentPurchases as $purchase)
                                                <tr>
                                                    <td>{{ $purchase->purchase_code }}</td>
                                                    <td>{{ $purchase->supplier ? $purchase->supplier->name : 'N/A' }}</td>
                                                    <td>${{ number_format($purchase->total_amount, 2) }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('M d, Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No recent purchases</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            Yesterday</div>
                        </div>
                    </div>
                    <!-- Recent Sales -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                            <div class="card-header py-3 border-0" style="background: linear-gradient(135deg, #2E7D32, #4CAF50); border-radius: 12px 12px 0 0;">
                                <h5 class="mb-0 text-white"><i class="fas fa-cash-register me-2"></i>Recent Sales</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" style="border-radius: 0 0 12px 12px;">
                                        <thead style="background-color: #2E7D32; color: white;">
                                            <tr>
                                                <th>Sale Code</th>
                                                <th>User</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($recentSales as $sale)
                                                <tr>
                                                    <td>{{ $sale->sale_code }}</td>
                                                    <td>{{ $sale->user ? $sale->user->name : 'N/A' }}</td>
                                                    <td>${{ number_format($sale->total_amount, 2) }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('M d, Y') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No recent sales</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .metric-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table tbody tr:nth-child(even) {
            background-color: #FAFAFA;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(46, 125, 50, 0.05);
        }
    </style>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function() {
            let salesChart = null;

            function renderSalesChart(data, labels) {
                if (salesChart) {
                    salesChart.destroy();
                }
                var salesOptions = {
                    chart: {
                        type: 'line',
                        height: 350,
                        toolbar: { show: false },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        },
                        zoom: { enabled: false }
                    },
                    series: [{
                        name: 'Sales Amount',
                        data: data
                    }],
                    xaxis: {
                        categories: labels,
                        labels: { style: { fontSize: '12px', fontFamily: 'Roboto' } }
                    },
                    yaxis: {
                        title: { text: 'Amount ($)', style: { fontFamily: 'Roboto' } },
                        labels: {
                            formatter: function(val) {
                                return '$' + val.toFixed(2);
                            },
                            style: { fontFamily: 'Roboto' }
                        }
                    },
                    colors: ['#2E7D32'],
                    stroke: { curve: 'smooth', width: 3 },
                    grid: { borderColor: '#E0E0E0' },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return '$' + val.toFixed(2);
                            }
                        }
                    }
                };
                salesChart = new ApexCharts(document.querySelector("#monthlySalesChart"), salesOptions);
                salesChart.render();
            }

            function fetchChartData(year) {
                $.ajax({
                    url: "{{ route('home.charts') }}",
                    type: 'GET',
                    data: { year: year },
                    success: function(response) {
                        // Render Monthly Sales Chart
                        renderSalesChart(response.monthlySales.data, response.monthlySales.labels);

                        // Stock by Category Pie Chart
                        var categoryOptions = {
                            chart: {
                                type: 'pie',
                                height: 350,
                                animations: {
                                    enabled: true,
                                    easing: 'easeinout',
                                    speed: 800
                                }
                            },
                            series: response.stockByCategory.data,
                            labels: response.stockByCategory.labels,
                            colors: ['#FF6F61', '#6B7280', '#FBBF24', '#34D399', '#3B82F6'],
                            legend: {
                                position: 'bottom',
                                fontSize: '14px',
                                fontFamily: 'Roboto'
                            },
                            dataLabels: {
                                formatter: function(val, opts) {
                                    return opts.w.config.series[opts.seriesIndex] + ' units';
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return val + ' units';
                                    }
                                }
                            }
                        };
                        var categoryChart = new ApexCharts(document.querySelector("#stockByCategoryChart"), categoryOptions);
                        categoryChart.render();

                        // Top Medicines Bar Chart
                        var medicineOptions = {
                            chart: {
                                type: 'bar',
                                height: 350,
                                toolbar: { show: false },
                                animations: {
                                    enabled: true,
                                    easing: 'easeinout',
                                    speed: 800
                                }
                            },
                            series: [{
                                name: 'Quantity Sold',
                                data: response.topMedicines.data
                            }],
                            xaxis: {
                                categories: response.topMedicines.labels,
                                labels: { style: { fontSize: '12px', fontFamily: 'Roboto' } }
                            },
                            yaxis: {
                                title: { text: 'Quantity', style: { fontFamily: 'Roboto' } },
                                labels: {
                                    formatter: function(val) {
                                        return Math.round(val);
                                    },
                                    style: { fontFamily: 'Roboto' }
                                }
                            },
                            colors: ['#0288D1'],
                            plotOptions: {
                                bar: { borderRadius: 4, horizontal: false }
                            },
                            dataLabels: { enabled: false },
                            grid: { borderColor: '#E0E0E0' },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return val + ' units';
                                    }
                                }
                            }
                        };
                        var medicineChart = new ApexCharts(document.querySelector("#topMedicinesChart"), medicineOptions);
                        medicineChart.render();
                    },
                    error: function(xhr) {
                        console.log('Chart Data AJAX Error:', xhr.status, xhr.responseText);
                        toastr.error('Failed to load chart data');
                    }
                });
            }

            // Initial chart load (2025)
            fetchChartData(2025);

            // Year filter change
            $('#yearFilter').on('change', function() {
                var selectedYear = $(this).val();
                fetchChartData(selectedYear);
            });
        });
    </script>
@endpush