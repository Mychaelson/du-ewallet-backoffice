<?php

namespace App\Repositories\Wallet;


use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WalletRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;


    function getJobs() {

        $jobs = DB::table('accounts.jobs')->get();

        return $jobs;
    }

    
    function getGroups() {

        $groups = DB::table('accounts.groups')->get();

        return $groups;
    }

    function getWalletList($query) {

        $get_data = DB::table("wallet.wallets")
                        ->join("accounts.users", "wallet.wallets.user_id", "accounts.users.id")
                        ->leftJoin("wallet.wallet_transactions", function ($join) {
                            $join->on("wallet.wallets.id", "=", "wallet.wallet_transactions.wallet_id")
                                ->whereMonth("wallet.wallet_transactions.created_at",Carbon::now()->format("m"))
                                ->whereYear("wallet.wallet_transactions.created_at",Carbon::now()->format("Y"))
                                ->where("wallet.wallet_transactions.status", 3);
                        })
                        ->select(
                            "wallet.wallets.id",
                            "accounts.users.username",
                            "accounts.users.nickname",
                            "accounts.users.phone",
                            "wallet.wallets.balance",
                            "wallet.wallets.lock_in",
                            "wallet.wallets.lock_out",
                            "wallet.wallets.lock_wd",
                            "wallet.wallets.lock_tf",
                            "wallet.wallets.lock_pm",
                            "wallet.wallets.type",
                            "wallet.wallets.reversal",
                            "wallet.wallets.created_at"
                        )
                        ->selectRaw("sum(case when wallet.wallet_transactions.note ='In' then wallet.wallet_transactions.amount else 0 end) as in")
                        ->selectRaw("sum(case when wallet.wallet_transactions.note ='Out' then wallet.wallet_transactions.amount else 0 end) as out")
                        ->where('wallet.wallets.type', 1)
                        ->groupBy(
                            "wallet.wallets.id",
                            "accounts.users.username",
                            "accounts.users.nickname",
                            "accounts.users.phone",
                            "wallet.wallets.balance",
                            "wallet.wallets.lock_in",
                            "wallet.wallets.lock_out",
                            "wallet.wallets.lock_wd",
                            "wallet.wallets.lock_tf",
                            "wallet.wallets.lock_pm",
                            "wallet.wallets.type",
                            "wallet.wallets.reversal",
                            "wallet.wallets.created_at"
                        );

        if (isset($query['filterPhone'])) {
            $get_data->where('accounts.users.phone', 'like', '%'.$query['filterPhone'].'%');
        }


        if(isset($query['filterlock'])){
            switch ($query['filterlock']) {
                case "Lock In":
                    $get_data->where('wallet.wallets.lock_in', 1);
                    break;
                case "Lock Out":
                    $get_data->where('wallet.wallets.lock_out', 1);
                    break;
                case "Lock Withdraw":
                    $get_data->where('wallet.wallets.lock_wd', 1);
                    break;
                case "Lock Transfer":
                    $get_data->where('wallet.wallets.lock_tf', 1);
                    break;
                case "Lock Payment":
                    $get_data->where('wallet.wallets.lock_pm', 1);
                    break;
            }
        }

        if (isset($query['startDateRegistered'])) {
            $get_data->where('accounts.users.created_at', '>=', $query['startDateRegistered']);
        }

        if (isset($query['endDateRegistered'])) {
            $get_data->where('accounts.users.created_at', '<=', $query['endDateRegistered']);
        }

        if (isset($query['filterRange'])) {
            if ($query['filterRange'] == 'Balance') {
                if (isset($query['minAmount'])) {
                    $get_data->where('wallet.wallets.balance', '>=', $query['minAmount']);
                }
    
                if (isset($query['maxAmount'])) {
                    $get_data->where('wallet.wallets.balance', '<=', $query['maxAmount']);
                }
            }
        }

        return $get_data;
    }

    function getWallet($filterName, $filterValue){
        $data = DB::table('wallet.wallets');

        if(isset($filterName)){
            $data->where($filterName,$filterValue);
        }

        return $data;
    }

    function updateById ($id, $data){
        $result = DB::table('wallet.wallets')
                    ->where('id', $id)
                    ->update($data);

        return $result;
    }

    function getWalletLimit ($wallet_id) {
        $data = DB::table("wallet.wallet_limits")
                    ->where('wallet', $wallet_id)
                    ->first();

        return $data;
    }

    public function getWalletTransactionBywalletId ($wallet_id){
        $data = DB::table("wallet.wallet_transactions")
                    ->groupBy('transaction_type')
                    ->select(
                        'transaction_type'
                    )
                    ->selectRaw('count(*)')
                    ->whereDate('created_at', '=', date('Y-m-d 00:00:00'))
                    ->get()
        ;

        return $data;
    }

    public function getWalletSummary ($wallet_id, $month = null, $year = null){
        if (!$month) {
            $month = now()->month;
        }
        if (!$year) {
            $year = now()->year;
        }

        $lastMonth =  Carbon::now()->subMonth()->format('m');

        $subQueryIn = DB::table("wallet.wallet_transactions")
                        ->where('note', 'In')
                        ->where('status', '3')
                        ->whereMonth('updated_at', '=', $month)
                        ->whereYear('updated_at', '=', $year)
                        ->selectRaw('sum(amount) as sum_transaction_in, wallet_id')
                        ->groupBy('wallet_id')
        ;
        $subQueryOut = DB::table("wallet.wallet_transactions")
                        ->where('note', 'Out')
                        ->where('status', '3')
                        ->whereMonth('updated_at', '=', $month)
                        ->whereYear('updated_at', '=', $year)
                        ->selectRaw('sum(amount) as sum_transaction_out, wallet_id')
                        ->groupBy('wallet_id')
        ;

        $subQueryLastMonthBalance = DB::table("wallet.wallet_transactions")
                                        ->where('status', '3')
                                        ->whereYear('updated_at', '=', $year)
                                        ->whereMonth('updated_at', '=', $lastMonth)
                                        ->orderByDesc('updated_at')
                                        ->limit(1)
        ;


        $data = DB::table("wallet.wallets")
                    ->join("wallet.wallet_limits", 'wallet.wallets.id', 'wallet.wallet_limits.wallet')
                    ->where('wallet.wallets.id', $wallet_id)
                    ->leftJoinSub($subQueryIn, 'transaction_in', function($join) {
                        $join->on('wallets.id', '=', 'transaction_in.wallet_id');
                    })
                    ->leftJoinSub($subQueryOut, 'transaction_out', function($join) {
                        $join->on('wallets.id', '=', 'transaction_out.wallet_id');
                    })
                    ->leftJoinSub($subQueryLastMonthBalance, 'last_transaction', function ($join){
                        $join->on('wallets.id', '=', 'last_transaction.wallet_id');
                    })
                    ->select(
                        'wallets.id',
                        'balance',
                        'max_balance',
                        'transaction_monthly',
                        'sum_transaction_in',
                        'sum_transaction_out',
                    )
                    ->selectRaw("
                        (case 
                            when last_transaction.note = 'In' then last_transaction.balance_before + last_transaction.amount
                            when last_transaction.note = 'Out' then last_transaction.balance_before - last_transaction.amount
                            end
                        ) as last_month_balance
                    ")
                    ->first()
        ;

        return $data;
    }

    public function getListOfBank (){
        $data = DB::table('accounts.banks')
                    ->select(
                        'id',
                        'code',
                        'name'
                    )
                    ->get();
        ; 

        return $data;
    }

    public function getBankAccountList ($user_id, $bank_id){
        $data = DB::table('accounts.bank_accounts')
                    ->where('user_id', $user_id)
                    ->where('bank_id', $bank_id)
                    ->get()
        ;

        return $data;
    }

    public function getSumWalletBalance ($query){
        $get_data = DB::table("wallet.wallets")
                        ->join("accounts.users", "wallet.wallets.user_id", "accounts.users.id")
                        ->where('wallet.wallets.type', 1)
        ;

        if (isset($query['filterPhone'])) {
            $get_data->where('accounts.users.phone', 'like', '%'.$query['filterPhone'].'%');
        }


        if(isset($query['filterlock'])){
            switch ($query['filterlock']) {
                case "Lock In":
                    $get_data->where('wallet.wallets.lock_in', 1);
                    break;
                case "Lock Out":
                    $get_data->where('wallet.wallets.lock_out', 1);
                    break;
                case "Lock Withdraw":
                    $get_data->where('wallet.wallets.lock_wd', 1);
                    break;
                case "Lock Transfer":
                    $get_data->where('wallet.wallets.lock_tf', 1);
                    break;
                case "Lock Payment":
                    $get_data->where('wallet.wallets.lock_pm', 1);
                    break;
            }
        }

        if (isset($query['startDateRegistered'])) {
            $get_data->where('accounts.users.created_at', '>=', $query['startDateRegistered']);
        }

        if (isset($query['endDateRegistered'])) {
            $get_data->where('accounts.users.created_at', '<=', $query['endDateRegistered']);
        }

        if (isset($query['filterRange'])) {
            if ($query['filterRange'] == 'Balance') {
                if (isset($query['minAmount'])) {
                    $get_data->where('wallet.wallets.balance', '>=', $query['minAmount']);
                }
    
                if (isset($query['maxAmount'])) {
                    $get_data->where('wallet.wallets.balance', '<=', $query['maxAmount']);
                }
            }
        }

        return $get_data->sum('wallet.wallets.balance');
    }
}
