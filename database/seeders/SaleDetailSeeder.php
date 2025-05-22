<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Retrieve sale IDs and medicine data (id and selling_price)
        $sales = DB::table('sales')->pluck('id')->toArray();
        $medicines = DB::table('medicines')->select('id', 'selling_price')->get()->toArray();

        // Ensure we have sales and medicines
        if (empty($sales) || empty($medicines)) {
            throw new \Exception('Sales or medicines table is empty. Please seed sales and medicines first.');
        }

        $saleDetails = [];

        // Generate 2-4 details per sale (approximately 90 records total)
        foreach ($sales as $saleId) {
            // Randomly select 2-4 medicines for this sale
            $numDetails = rand(2, 4);
            $selectedMedicines = array_rand($medicines, $numDetails);
            if (!is_array($selectedMedicines)) {
                $selectedMedicines = [$selectedMedicines];
            }

            foreach ($selectedMedicines as $index) {
                $medicine = $medicines[$index];
                $quantity = rand(1, 20); // Realistic quantity for retail sales
                $unitPrice = $medicine->selling_price; // Use medicine's selling_price
                $subtotal = $quantity * $unitPrice;

                $saleDetails[] = [
                    'sale_id' => $saleId,
                    'medicine_id' => $medicine->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('sale_details')->insert($saleDetails);

        // Update sales.total_amount to match sum of sale_details.subtotal
        foreach ($sales as $saleId) {
            $total = DB::table('sale_details')
                ->where('sale_id', $saleId)
                ->sum('subtotal');
            DB::table('sales')
                ->where('id', $saleId)
                ->update(['total_amount' => $total]);
        }
    }
}
