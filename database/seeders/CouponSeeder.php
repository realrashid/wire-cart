<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'FIXED20',
            'type' => 'fixed_amount',
            'amount' => 20.00,
            'expiry_date' => '2024-12-31',
        ]);

        Coupon::create([
            'code' => 'PERCENT25',
            'type' => 'percentage',
            'percentage' => 25,
            'expiry_date' => '2024-12-31',
        ]);

        Coupon::create([
            'code' => 'FIXED100',
            'type' => 'fixed_amount',
            'amount' => 100.00,
            'expiry_date' => '2024-02-28',
        ]);

        Coupon::create([
            'code' => 'PERCENT35',
            'type' => 'percentage',
            'percentage' => 35,
            'expiry_date' => '2024-04-30',
        ]);
    }
}
