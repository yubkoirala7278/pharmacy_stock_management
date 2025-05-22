<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Retrieve supplier IDs and user IDs
        $suppliers = DB::table('suppliers')->pluck('id')->toArray();
        $users = DB::table('users')->pluck('id')->toArray();

        // Ensure we have suppliers and users
        if (empty($suppliers) || empty($users)) {
            throw new \Exception('Suppliers or users table is empty. Please seed suppliers and users first.');
        }

        $purchases = [];

        // Generate 30 purchase records
        for ($i = 1; $i <= 30; $i++) {
            $purchaseDate = now()->subDays(rand(0, 365))->format('Y-m-d'); // Random date within the last year
            $purchaseCode = 'PUR-' . date('Ym') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT); // e.g., PUR-202505-001
            $totalAmount = rand(500, 5000) + (rand(0, 99) / 100); // Random amount between $500.00 and $5000.99

            $purchases[] = [
                'slug' => Str::slug('Purchase ' . $purchaseCode),
                'supplier_id' => $suppliers[array_rand($suppliers)], // Random supplier
                'user_id' => $users[array_rand($users)], // Random user
                'purchase_code' => $purchaseCode,
                'purchase_date' => $purchaseDate,
                'total_amount' => $totalAmount,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('purchases')->insert($purchases);
    }
}
