<?php

namespace App\Repositories\Wallet;


use Illuminate\Support\Facades\DB;


class HistoryRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;

    public function getHistoryList ($query, $filterByWallet = null) {
        $data = DB::table('wallet.wallet_transactions')
                    ->join('wallet.wallets', 'wallet.wallets.id', 'wallet.wallet_transactions.wallet_id')
                    ->join('accounts.users', 'accounts.users.id', 'wallet.wallets.user_id')
                    ->select(
                        'wallet.wallet_transactions.id',
                        'wallet.wallets.type',
                        'wallet.wallet_transactions.status',
                        'wallet.wallet_transactions.transaction_type',
                        'wallet.wallet_transactions.amount',
                        'accounts.users.name',
                        'accounts.users.id as user_id',
                        'wallet.wallet_transactions.created_at',
                        'wallet.wallet_transactions.updated_at'
                    )
                    ->selectRaw("(case
                                    when wallet.wallet_transactions.note = 'In' and wallet.wallet_transactions.status = '3' 
                                        then wallet.wallet_transactions.balance_before + wallet.wallet_transactions.amount
                                    when wallet.wallet_transactions.note = 'Out' and wallet.wallet_transactions.status = '3' 
                                        then wallet.wallet_transactions.balance_before + (wallet.wallet_transactions.amount * -1) 
                                    else wallet.wallet_transactions.balance_before
                                    end) as balance
                    ")
                    ->orderBy('wallet.wallet_transactions.id', 'asc')
        ;

        if(isset( $query['transaction_type']))
        {
            $data->where('wallet.wallet_transactions.transaction_type', '=',  $query['transaction_type']);
        }

        if(isset( $query['transaction_status']))
        {
            $data->where('wallet.wallet_transactions.status', '=',  $query['transaction_status']);
        }


        if(isset($query['date_from'])) {
            $data->where('wallet.wallet_transactions.'.$query['filter_date_by'], '>=', $query['date_from'] );
        }

        if(isset($query['date_to'])) {
            $data->where('wallet.wallet_transactions.'.$query['filter_date_by'], '<=', $query['date_to'] );
        }

        if (isset($query['wallet_id'])) {
            $data->where('wallet.wallets.id', $query['wallet_id']);
        }

        return $data;
    }


    public function getTransactionType () {
        $data = DB::table('wallet.wallet_transactions')->distinct()->get(['transaction_type']);
        ;

        return $data;
    }

    public function getLatestUserTransaction ($wallet_id){
        $data = DB::table('wallet.wallet_transactions')
                    ->select(
                        'wallet.wallet_transactions.status',
                        'wallet.wallet_transactions.transaction_type',
                        'wallet.wallet_transactions.amount',
                        'wallet.wallet_transactions.created_at',
                        'wallet.wallet_transactions.updated_at'
                    )
                    ->selectRaw("(case
                                    when wallet.wallet_transactions.note = 'In' and wallet.wallet_transactions.status = '3' 
                                        then wallet.wallet_transactions.balance_before + wallet.wallet_transactions.amount
                                    when wallet.wallet_transactions.note = 'Out' and wallet.wallet_transactions.status = '3' 
                                        then wallet.wallet_transactions.balance_before + (wallet.wallet_transactions.amount * -1) 
                                    else wallet.wallet_transactions.balance_before
                                    end) as balance
                    ")
                    ->where('wallet_id', $wallet_id)
                    ->orderBy('wallet.wallet_transactions.updated_at', 'desc')
                    ->limit(10)
                    ->get()
        ;

        return $data;
    }
}
