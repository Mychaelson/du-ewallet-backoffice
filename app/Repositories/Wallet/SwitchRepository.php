<?php

namespace App\Repositories\Wallet;


use Illuminate\Support\Facades\DB;


class SwitchRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;

    function getList($query) {

        $get_data = DB::table('wallet.switching_fee_banks')
                        ->leftJoin('accounts.banks as bank_from', 'wallet.switching_fee_banks.bank_from', '=', 'bank_from.code' )
                        ->leftJoin('accounts.banks as bank_to', 'wallet.switching_fee_banks.bank_to', '=', 'bank_to.code' )
                        ->select(
                            'bank_from.name as bank_from_name',
                            'bank_to.name as bank_to_name',
                            'wallet.switching_fee_banks.bank_from',
                            'wallet.switching_fee_banks.bank_to',
                            'wallet.switching_fee_banks.fee',
                            'wallet.switching_fee_banks.cgs',
                            'wallet.switching_fee_banks.id',
                            'wallet.switching_fee_banks.created_at',
                            'wallet.switching_fee_banks.updated_at',
                        )
        ;

        return $get_data;
    }

    function getSwitchInfo ($condition) {
        $get_data = DB::table('wallet.switching_fee_banks')
                        ->where($condition)
                        ->first();
        
        return $get_data;
    }

    function getBankList () {
        $data = DB::table('accounts.banks')->get();
        
        return $data;
    }

    function updateById ($id, $data){
        $data = DB::table('wallet.switching_fee_banks')
                    ->where('id', $id)
                    ->update($data);
        
        return $data;
    }

    function store ($data){
        $data = DB::table('wallet.switching_fee_banks')
                    ->insert($data);

        return $data;
    }
}
