<?php

namespace App\Repositories\User;


use Illuminate\Support\Facades\DB;


class CloseAccountsLogRepository
{
    public function get_data($query){
        $data = DB::table('accounts.close_account')
        ->leftjoin('accounts.users as by_name','by_name.id','=','accounts.close_account.user_id',)
        ->leftjoin('accounts.users as by_approval','by_approval.id','=','accounts.close_account.approval_by')
        ->select('by_name.name as name','by_approval.name as approval','accounts.close_account.status','accounts.close_account.id','accounts.close_account.approved_at','accounts.close_account.user_id')
        ->orderBy('accounts.close_account.approved_at','desc');
        return $data;
    }
}
