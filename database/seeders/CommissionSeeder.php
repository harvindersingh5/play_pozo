<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $now = Carbon::now();
        $commission = [
            [
                'name' => 'Default Commission',
                'type' => 'PERCENTAGE',
                'value' => '10',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Flat Commission',
                'type' => 'FLAT',
                'value' => '50',
                'created_at' => $now,
                'updated_at' => $now,
            ]

        ];

         DB::table('commissions')->insert($commission);
    }
}
