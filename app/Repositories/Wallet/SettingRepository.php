<?php

namespace App\Repositories\Wallet;


use Illuminate\Support\Facades\DB;


class SettingRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;

    function getSettingList($query) {

        $get_data = DB::table('setting.site_params');

        return $get_data;
    }

    function getInfo ($condition) {
        $get_data = DB::table('setting.site_params')
                        ->where($condition)
                        ->first();
        
        return $get_data;
    }

    function updateById ($id, $data){
        $data = DB::table('setting.site_params')
                    ->where('id', $id)
                    ->update($data);
        
        return $data;
    }
}
