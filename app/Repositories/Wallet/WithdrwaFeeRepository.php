<?php

namespace App\Repositories\Wallet;


use Illuminate\Support\Facades\DB;


class WithdrwaFeeRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;

    function allList($query) {

        $get_data = DB::table('wallet.wallet_withdraw_fee');

        return $get_data;
    }

    function getList($filter, $value){

        $data = DB::table('wallet.wallet_withdraw_fee')
                    ->where($filter, $value);

        return $data;
    }

    function updateById ($id, $data){
        $data = DB::table('wallet.wallet_withdraw_fee')
                    ->where('id', $id)
                    ->update($data);

        return $data;
    }

    function removeById ($id, $data){
        $data = DB::table('wallet.wallet_withdraw_fee')
                    ->where('id', $id)
                    ->delete();

        return $data;
    }

    function add ($data){
        $data = DB::table('wallet.wallet_withdraw_fee')
                    ->insert($data);

        return $data;
    }
}
