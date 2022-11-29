<?php

namespace App\Repositories\Wallet;


use Illuminate\Support\Facades\DB;


class LabelRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;

    function getList($query) {

        $get_data = DB::table('wallet.wallet_labels');

        return $get_data;
    }

    function getLabel($filter){

        $data = DB::table('wallet.wallet_labels')
                    ->where($filter)
                    ->first();

        return $data;
    }

    function updateById ($id, $data){
        $data = DB::table('wallet.wallet_labels')
                    ->where('id', $id)
                    ->update($data);

        return $data;
    }

    function add ($data){
        $data = DB::table('wallet.wallet_labels')
                    ->insert($data);

        return $data;
    }
}
