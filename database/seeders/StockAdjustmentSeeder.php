<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockAdjustmentSeeder extends Seeder
{
    public function run()
    {
        // Retrieve medicine IDs and user IDs
        $medicines = DB::table('medicines')->pluck('id')->toArray();
        $users = DB::table('users')->pluck('id')->toArray();

        // Ensure we have medicines and users
        if (empty($medicines) || empty($users)) {
            throw new \Exception('Medicines or users table is empty. Please seed medicines and users first.');
        }

        $adjustments = [];

        // Generate 30 stock adjustment records
        for ($i = 1; $i <= 30; $i++) {
            $adjustmentDate = now()->subDays(rand(0, 365))->format('Y-m-d'); // Random date within the last year
            $quantity = rand(5, 50); // Realistic adjustment quantity
            $type = rand(0, 1) ? 'add' : 'remove'; // Randomly add or remove
            $hasReason = rand(0, 1); // 50% chance of reason

            $adjustments[] = [
                'medicine_id' => $medicines[array_rand($medicines)], // Random medicine
                'user_id' => $users[array_rand($users)], // Random user
                'quantity' => $quantity,
                'type' => $type,
                'reason' => $hasReason ? $this->randomReason($type) : null,
                'adjustment_date' => $adjustmentDate,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('stock_adjustments')->insert($adjustments);

        // Update medicines.stock_quantity based on adjustments
        $adjustments = DB::table('stock_adjustments')->get();
        foreach ($adjustments as $adjustment) {
            $quantityChange = $adjustment->type === 'add' ? $adjustment->quantity : -$adjustment->quantity;
            DB::table('medicines')
                ->where('id', $adjustment->medicine_id)
                ->increment('stock_quantity', $quantityChange);
        }
    }

    private function randomReason($type)
    {
        $reasons = [
            'add' => [
                'Received additional stock from supplier',
                'Inventory correction after audit',
                'Returned stock from customer',
                'Promotional stock received',
            ],
            'remove' => [
                'Stock damaged or expired',
                'Inventory correction after audit',
                'Stock lost or stolen',
                'Donated to charity',
            ],
        ];
        return $reasons[$type][array_rand($reasons[$type])];
    }
}
