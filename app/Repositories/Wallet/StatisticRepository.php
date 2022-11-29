<?php

namespace App\Repositories\Wallet;


use Illuminate\Support\Facades\DB;


class StatisticRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;

    public function getList ($query) {

        $subQuery1 = DB::table('wallet.wallet_transactions')
                        ->selectRaw("to_char(created_at, 'DD-MM-YYYY') as date")
                        ->selectRaw('count(*) as qty_erased')
                        ->where('status', '0')
                        ->groupBy(DB::raw("to_char(created_at, 'DD-MM-YYYY')"))
        ;

        $subQuery2 = DB::table('wallet.wallet_transactions')
                        ->selectRaw("to_char(created_at, 'DD-MM-YYYY') as date")
                        ->selectRaw('count(*) as qty_cancel')
                        ->where('status', '1')
                        ->groupBy(DB::raw("to_char(created_at, 'DD-MM-YYYY')"))
        ;

        $subQuery3 = DB::table('wallet.wallet_transactions')
                        ->selectRaw("to_char(created_at, 'DD-MM-YYYY') as date")
                        ->selectRaw('count(*) as qty_pending')
                        ->where('status', '2')
                        ->groupBy(DB::raw("to_char(created_at, 'DD-MM-YYYY')"))
        ;

        $subQuery4 = DB::table('wallet.wallet_transactions')
                        ->selectRaw("to_char(created_at, 'DD-MM-YYYY') as date")
                        ->selectRaw('count(*) as qty_success')
                        ->where('status', '3')
                        ->groupBy(DB::raw("to_char(created_at, 'DD-MM-YYYY')"))
        ;

        if(isset( $query['transaction_type']))
        {
            $subQuery1->where('wallet.wallet_transactions.transaction_type', '=',  $query['transaction_type']);
            $subQuery2->where('wallet.wallet_transactions.transaction_type', '=',  $query['transaction_type']);
            $subQuery3->where('wallet.wallet_transactions.transaction_type', '=',  $query['transaction_type']);
            $subQuery4->where('wallet.wallet_transactions.transaction_type', '=',  $query['transaction_type']);
        }

        $data = DB::table('wallet.wallet_transactions')
                    ->leftJoinSub($subQuery1, 'erased', function($join) {
                        $join->on(DB::raw("to_char(created_at, 'DD-MM-YYYY')"), '=', 'erased.date');
                    })
                    ->leftJoinSub($subQuery2, 'cancel', function($join) {
                        $join->on(DB::raw("to_char(created_at, 'DD-MM-YYYY')"), '=', 'cancel.date');
                    })
                    ->leftJoinSub($subQuery3, 'pending', function($join) {
                        $join->on(DB::raw("to_char(created_at, 'DD-MM-YYYY')"), '=', 'pending.date');
                    })
                    ->leftJoinSub($subQuery4, 'success', function($join) {
                        $join->on(DB::raw("to_char(created_at, 'DD-MM-YYYY')"), '=', 'success.date');
                    })
                    ->select(
                        DB::raw("
                            to_char(created_at, 'DD-MM-YYYY' ) as date, 
                            count(*) as quantity, 
                            sum(wallet.wallet_transactions.amount) as amount, 
                            erased.qty_erased,
                            cancel.qty_cancel,
                            pending.qty_pending,
                            success.qty_success
                        "),
                    )
                    ->groupBy(
                        DB::raw("
                            to_char(created_at, 'DD-MM-YYYY'), 
                            erased.qty_erased, 
                            cancel.qty_cancel, 
                            pending.qty_pending, 
                            success.qty_success")
                    )
        ;

        if(isset( $query['transaction_type']))
        {
            $data->where('wallet.wallet_transactions.transaction_type', '=',  $query['transaction_type']);
        }

        if(isset($query['date_from'])) {
            $data->where('wallet.wallet_transactions.created_at', '>', $query['date_from'] );
        }

        if(isset($query['date_to'])) {
            $data->where('wallet.wallet_transactions.created_at', '<', $query['date_to'] );
        }

        return $data;
    }
}
