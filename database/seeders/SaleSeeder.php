<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Retrieve user IDs
        $users = DB::table('users')->pluck('id')->toArray();

        // Ensure we have users
        if (empty($users)) {
            throw new \Exception('Users table is empty. Please seed users first.');
        }

        $sales = [];

        // Generate 30 sales records
        for ($i = 1; $i <= 30; $i++) {
            $saleDate = now()->subDays(rand(0, 365))->format('Y-m-d'); // Random date within the last year
            $saleCode = 'SALE-' . date('Ym') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT); // e.g., SALE-202505-001
            $totalAmount = rand(50, 500) + (rand(0, 99) / 100); // Random amount between $50.00 and $500.99
            $paidAmount = rand(0, 1) ? $totalAmount * (rand(50, 100) / 100) : 0; // 50-100% paid or unpaid
            $dueAmount = $totalAmount - $paidAmount; // Remaining due
            $hasCustomer = rand(0, 1); // 50% chance of customer details

            $sales[] = [
                'slug' => Str::slug('Sale ' . $saleCode),
                'user_id' => $users[array_rand($users)], // Random user
                'sale_code' => $saleCode,
                'sale_date' => $saleDate,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'customer_name' => $hasCustomer ? $this->randomCustomerName() : null,
                'customer_phone' => $hasCustomer ? $this->randomPhoneNumber() : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('sales')->insert($sales);
    }

    private function randomCustomerName()
    {
        $firstNames = ['John', 'Emma', 'Michael', 'Sarah', 'David', 'Laura', 'James', 'Emily', 'Robert', 'Sophia'];
        $lastNames = ['Smith', 'Johnson', 'Brown', 'Davis', 'Wilson', 'Martinez', 'Thompson', 'Clark', 'Harris', 'Lewis'];
        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }

    private function randomPhoneNumber()
    {
        return '+1-555-' . rand(100, 999) . '-' . rand(1000, 9999);
    }
}
