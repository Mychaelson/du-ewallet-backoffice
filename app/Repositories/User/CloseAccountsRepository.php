<?php

namespace App\Repositories\User;


use Illuminate\Support\Facades\DB;


class CloseAccountsRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;

    public function getCloseAccountsList ($query){
      $data = DB::table('accounts.close_account')
                  ->leftJoin('accounts.users', 'accounts.users.id', '=', 'accounts.close_account.user_id')
                  ->select(
                    'accounts.close_account.id',
                    'accounts.close_account.user_id',
                    'accounts.close_account.status',
                    'accounts.close_account.emoticon',
                    'accounts.close_account.content',
                    'accounts.close_account.approval_by',
                    'accounts.close_account.approved_at',
                    'accounts.close_account.reason',
                    'accounts.close_account.meta',
                    'accounts.close_account.created_at',
                    'accounts.close_account.updated_at',
                    'accounts.close_account.updated_at',
                    'accounts.users.username',
                    'accounts.users.name',
                    'accounts.users.nickname',
                    'accounts.users.email',
                    'accounts.users.email_verified',
                    'accounts.users.phone',
                    'accounts.users.phone_code',
                    'accounts.users.user_type',
                    'accounts.users.verified',
                    'accounts.users.locale',
                  )
      ;

      if(isset($query['id']))
      {
          $data->where('accounts.close_account.id', $query['id']);
          return $data->first();
      }

      return $data;
    }

    public function updateCloseAccount ($data, $id){
      $data = DB::table('accounts.close_account')
                ->where('id', $id)
                ->update($data);

      return $data;
    }
}
