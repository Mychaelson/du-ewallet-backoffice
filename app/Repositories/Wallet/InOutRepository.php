<?php

namespace App\Repositories\Wallet;


use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InOutRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;

    function getList($query) {

        $get_data = DB::table("wallet.wallet_transactions as a")
                        ->leftJoin("wallet.wallet_topup as b", function ($join) {
                            $join->on(DB::raw("CAST ( a.reff_id AS int )"), "=", "b.id")
                                ->where("a.transaction_type", "'Topup'");
                        })
                        ->leftJoin("wallet.wallet_withdraw as c", function ($join) {
                            $join->on(DB::raw("CAST ( a.reff_id AS int )"), "=", "c.id")
                                ->where("a.transaction_type", "'Withdraw'");
                        })
                        ->selectRaw("
                        a.created_at::DATE as date,
                        (case when a.transaction_type ='Topup' then b.bank_account_number 
                            when a.transaction_type ='Withdraw' then c.bank_account_number end) bank_account_number,
                        (case when a.transaction_type ='Topup' then b.bank_account_name 
		                    when a.transaction_type ='Withdraw' then c.bank_account_name end) bank_account_name,
                        (case when a.transaction_type ='Topup' then concat(b.bank_code)
                            when a.transaction_type ='Withdraw' then c.bank_code end) bank_code,	
                        (case when a.transaction_type ='Topup' then b.bank_name
                            when a.transaction_type ='Withdraw' then c.bank_name end) bank_name,
                        sum((case when a.note = 'In' then a.amount else 0 end)) amount_in,
                        sum((case when a.note = 'Out' then a.amount else 0 end)) amount_out,
                        count(*) quantity 
                        ")
                        ->where("a.status", "3")
                        ->whereIn("a.transaction_type", ["Topup", "Withdraw"])
                        ->groupByRaw("
                        a.created_at::DATE,
                        (case when a.transaction_type ='Topup' then b.bank_account_number 
                            when a.transaction_type ='Withdraw' then c.bank_account_number end),
                        (case when a.transaction_type ='Topup' then b.bank_account_name 
		                    when a.transaction_type ='Withdraw' then c.bank_account_name end),
                        (case when a.transaction_type ='Topup' then concat(b.bank_code)
                            when a.transaction_type ='Withdraw' then c.bank_code end),	
                        (case when a.transaction_type ='Topup' then b.bank_name
                            when a.transaction_type ='Withdraw' then c.bank_name end)");

        if(isset($query['date_from'])) {
            $get_data->where('a.created_at', '>', $query['date_from'] );
        }

        if(isset($query['date_to'])) {
            $get_data->where('a.created_at', '<', $query['date_to'] );
        }

        return $get_data;
    }
}
