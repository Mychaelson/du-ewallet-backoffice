<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryBanner extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banner.banner_catergory')->insert([
            [
                'name' =>  'bpjs'
            ],[
                'name' =>'cellular-postpaid'
            ],[
                'name' => 'education'
            ],[
                'name' => 'electricity'
            ],[
                'name' => 'environment'
            ],[
                'name' => 'e_money'
            ],[
                'name' => 'info'
            ],[
                'name' => 'insurance'
            ],[
                'name' => 'merchant_page'
            ],[
                'name' => 'multifinance'
            ],[
                'name' => 'paid_tv'
            ],[
                'name' => 'pdam'
            ],[
                'name' => 'pgn'
            ],[
                'name' => 'referral'
            ],[
                'name' => 'telecom'
            ],[
                'name' => 'telkom'
            ],[
                'name' => 'voucher_game'
            ]
        ]);
    }
}
