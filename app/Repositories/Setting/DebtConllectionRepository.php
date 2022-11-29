<?php

namespace App\Repositories\Setting;

use App\Models\Setting\Params;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class DebtConllectionRepository
{
    public function index(){
        $data = DB::table('wallet.wallets')
        ->leftJoin('accounts.users','accounts.users.id','=','wallet.wallets.user_id')
        ->leftJoin('accounts.user_groups','accounts.user_groups.id','=','accounts.users.group_id')
        ->leftJoin('wallet.reversal','wallet.reversal.wallet','=','wallet.wallets.id')
        ->select(
            'accounts.users.nickname','accounts.users.name','accounts.users.verified','accounts.users.username','accounts.user_groups.name as group_name',
            'wallet.wallets.balance','wallet.wallets.reversal','wallet.reversal.amount','wallet.wallets.currency','wallet.wallets.id'
        );

        return $data;
    }
}
