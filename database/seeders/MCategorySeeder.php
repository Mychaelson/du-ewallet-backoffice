<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memberships.category')->insert(
        	['id' => 1, 'name' => 'General', 'slug' => 'general']
        );

        DB::table('memberships.category')->insert(
        	['id' => 2, 'name' => 'Food & Beverages', 'slug' => 'food-beverages']
        );
    }
}
