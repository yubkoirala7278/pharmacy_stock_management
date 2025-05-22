<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'slug' => Str::slug('PharmaCorp Ltd'),
                'name' => 'PharmaCorp Ltd',
                'contact_person' => 'John Smith',
                'email' => 'contact@pharmacorp.com',
                'phone' => '+1-555-123-4567',
                'address' => '123 Health St, MedCity, USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => Str::slug('MediSupply Inc'),
                'name' => 'MediSupply Inc',
                'contact_person' => 'Sarah Johnson',
                'email' => 'sarah@medisupply.com',
                'phone' => '+1-555-987-6543',
                'address' => '456 Wellness Ave, Drugtown, USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => Str::slug('HealthDistributors'),
                'name' => 'HealthDistributors',
                'contact_person' => null,
                'email' => 'info@healthdistributors.com',
                'phone' => null,
                'address' => '789 Cure Blvd, Pharmaville, USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => Str::slug('Global Pharma'),
                'name' => 'Global Pharma',
                'contact_person' => 'Michael Brown',
                'email' => null,
                'phone' => '+1-555-456-7890',
                'address' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => Str::slug('BioMed Solutions'),
                'name' => 'BioMed Solutions',
                'contact_person' => 'Emily Davis',
                'email' => 'emily@biomed.com',
                'phone' => '+1-555-321-6543',
                'address' => '101 Vital Rd, CareCity, USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => Str::slug('CarePharma Co'),
                'name' => 'CarePharma Co',
                'contact_person' => null,
                'email' => null,
                'phone' => '+1-555-654-3210',
                'address' => '202 Recovery Ln, Healthville, USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => Str::slug('PureHealth Suppliers'),
                'name' => 'PureHealth Suppliers',
                'contact_person' => 'David Wilson',
                'email' => 'david@purehealth.com',
                'phone' => null,
                'address' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => Str::slug('VitaPharm Ltd'),
                'name' => 'VitaPharm Ltd',
                'contact_person' => 'Laura Martinez',
                'email' => 'laura@vitapharm.com',
                'phone' => '+1-555-789-1234',
                'address' => '303 Pill St, Medtown, USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => Str::slug('Wellness Distributors'),
                'name' => 'Wellness Distributors',
                'contact_person' => null,
                'email' => 'support@wellnessdist.com',
                'phone' => '+1-555-147-2589',
                'address' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => Str::slug('Rx Supplies'),
                'name' => 'Rx Supplies',
                'contact_person' => 'James Lee',
                'email' => null,
                'phone' => null,
                'address' => '404 Healing Dr, Cureville, USA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('suppliers')->insert($suppliers);
    }
}
