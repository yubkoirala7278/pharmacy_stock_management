<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        // Retrieve sales (id and paid_amount) and user IDs
        $sales = DB::table('sales')->select('id', 'paid_amount')->where('paid_amount', '>', 0)->get()->toArray();
        $users = DB::table('users')->pluck('id')->toArray();

        // Ensure we have sales with paid_amount > 0 and users
        if (empty($sales) || empty($users)) {
            throw new \Exception('Sales with paid_amount > 0 or users table is empty. Please seed sales and users first.');
        }

        $payments = [];

        // Generate one payment per sale with paid_amount > 0
        foreach ($sales as $index => $sale) {
            $paymentDate = now()->subDays(rand(0, 365))->format('Y-m-d'); // Random date within the last year
            $paymentCode = 'PAY-' . date('Ym') . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT); // e.g., PAY-202505-001
            $amount = $sale->paid_amount; // Match sale's paid_amount
            $paymentMethod = $this->randomPaymentMethod();
            $hasNotes = rand(0, 1); // 50% chance of notes

            $payments[] = [
                'slug' => Str::slug('Payment ' . $paymentCode),
                'sale_id' => $sale->id,
                'user_id' => $users[array_rand($users)], // Random user
                'amount' => $amount,
                'payment_date' => $paymentDate,
                'payment_method' => $paymentMethod,
                'notes' => $hasNotes ? $this->randomNotes($paymentMethod) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Ensure we have at least 30 payments by adding additional payments for random sales
        while (count($payments) < 30) {
            $sale = $sales[array_rand($sales)];
            $paymentDate = now()->subDays(rand(0, 365))->format('Y-m-d');
            $paymentCode = 'PAY-' . date('Ym') . '-' . str_pad(count($payments) + 1, 3, '0', STR_PAD_LEFT);
            $amount = rand(10, 100) + (rand(0, 99) / 100); // Random amount between $10.00 and $100.99
            $paymentMethod = $this->randomPaymentMethod();
            $hasNotes = rand(0, 1);

            $payments[] = [
                'slug' => Str::slug('Payment ' . $paymentCode),
                'sale_id' => $sale->id,
                'user_id' => $users[array_rand($users)],
                'amount' => $amount,
                'payment_date' => $paymentDate,
                'payment_method' => $paymentMethod,
                'notes' => $hasNotes ? $this->randomNotes($paymentMethod) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('payments')->insert($payments);

        // Update sales.paid_amount to sum of payments.amount for each sale
        foreach ($sales as $sale) {
            $totalPaid = DB::table('payments')
                ->where('sale_id', $sale->id)
                ->sum('amount');
            DB::table('sales')
                ->where('id', $sale->id)
                ->update([
                    'paid_amount' => $totalPaid,
                    'due_amount' => DB::raw('total_amount - ' . $totalPaid),
                ]);
        }
    }

    private function randomPaymentMethod()
    {
        $methods = ['cash', 'card', 'mobile'];
        return $methods[array_rand($methods)];
    }

    private function randomNotes($paymentMethod)
    {
        $notes = [
            'cash' => [
                'Paid in full at counter',
                'Customer paid with cash, change returned',
                'Cash payment verified by cashier',
            ],
            'card' => [
                'Paid via credit card, transaction ID: ' . Str::random(8),
                'Card payment processed successfully',
                'Debit card used, no issues',
            ],
            'mobile' => [
                'Paid via mobile app, ref: ' . Str::random(10),
                'Mobile payment confirmed',
                'Payment via digital wallet',
            ],
        ];
        return $notes[$paymentMethod][array_rand($notes[$paymentMethod])];
    }
}
