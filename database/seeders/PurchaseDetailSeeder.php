<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Retrieve purchase IDs and medicine data (id and cost_price)
        $purchases = DB::table('purchases')->pluck('id')->toArray();
        $medicines = DB::table('medicines')->select('id', 'cost_price')->get()->toArray();

        // Ensure we have purchases and medicines
        if (empty($purchases) || empty($medicines)) {
            throw new \Exception('Purchases or medicines table is empty. Please seed purchases and medicines first.');
        }

        $purchaseDetails = [];

        // Generate 2-4 details per purchase (approximately 90 records total)
        foreach ($purchases as $purchaseId) {
            // Randomly select 2-4 medicines for this purchase
            $numDetails = rand(2, 4);
            $selectedMedicines = array_rand($medicines, $numDetails);
            if (!is_array($selectedMedicines)) {
                $selectedMedicines = [$selectedMedicines];
            }

            foreach ($selectedMedicines as $index) {
                $medicine = $medicines[$index];
                $quantity = rand(10, 100); // Realistic quantity per medicine
                $unitPrice = $medicine->cost_price; // Use medicine's cost_price
                $subtotal = $quantity * $unitPrice;

                $purchaseDetails[] = [
                    'purchase_id' => $purchaseId,
                    'medicine_id' => $medicine->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('purchase_details')->insert($purchaseDetails);
    }
}
