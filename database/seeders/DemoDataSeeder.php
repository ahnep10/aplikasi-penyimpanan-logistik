<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Global Logistics Co.',
                'contact_person' => 'John Doe',
                'phone' => '123456789',
                'email' => 'john@global.com',
                'address' => '123 Logistics St, New York',
            ],
            [
                'name' => 'FastSupply Inc.',
                'contact_person' => 'Jane Smith',
                'phone' => '987654321',
                'email' => 'jane@fastsupply.com',
                'address' => '456 Supply Rd, Chicago',
            ],
        ];

        foreach ($suppliers as $s) {
            Supplier::create($s);
        }

        $products = [
            ['sku' => 'PROD-001', 'name' => 'Standard Pallet', 'unit' => 'piece', 'safety_stock' => 10],
            ['sku' => 'PROD-002', 'name' => 'Industrial Film', 'unit' => 'roll', 'safety_stock' => 5],
            ['sku' => 'PROD-003', 'name' => 'Heavy Duty Crate', 'unit' => 'piece', 'safety_stock' => 20],
            ['sku' => 'PROD-004', 'name' => 'Shipping Tape', 'unit' => 'box', 'safety_stock' => 50],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
