<?php

namespace App\Repositories\Wallet;

use App\Models\WalletUser\TransferBlacklist;
use App\Models\WalletUser\WithdrawBlacklist;
use Illuminate\Support\Facades\DB;


class WalletSettingRepository
{

    public $status  = 'status';
    public $error   = 'error';
    public $user_data;
    public $sess;

    public function getWalletSetting ($fiture = null, $wallet_id = null, $status = null){
      $data = DB::table('wallet.wallet_setting')
                ->join('backoffice.user', 'wallet.wallet_setting.requested_by', DB::raw('CAST(backoffice.user.id as varchar)'))
                ->select(
                  'wallet.wallet_setting.id',
                  'wallet.wallet_setting.wallet_id',
                  'wallet.wallet_setting.fiture',
                  'wallet.wallet_setting.status',
                  'wallet.wallet_setting.changes',
                  'wallet.wallet_setting.requested_by',
                  'wallet.wallet_setting.approved_by',
                  'wallet.wallet_setting.created_at',
                  'wallet.wallet_setting.updated_at',
                  'wallet.wallet_setting.document',
                  'wallet.wallet_setting.reason',
                  'backoffice.user.name'
                )
      ;

      if (isset($fiture)) {
          $data->where('fiture', $fiture);
      }
      if (isset($wallet_id)) {
          $data->where('wallet_id', $wallet_id);
      }
      if (isset($status)) {
          $data->where('wallet.wallet_setting.status', $status);
      }

      return $data;
    }

    public function insertWalletSetting ($data){
        $data = DB::table('wallet.wallet_setting')->insert($data);

        return $data;
    }

    public function checkCurrentPendingSettingByfiture ($fiture, $wallet_id){
        $data = DB::table('wallet.wallet_setting')
                    ->where('fiture', $fiture)
                    ->where('wallet_id', $wallet_id)
                    ->where('status', '2')
                    ->first();

        return $data;
    }

    public function getWalletSettingById ($id){
      $data = DB::table('wallet.wallet_setting')
                  ->where('wallet.wallet_setting.id', $id)
                  ->leftJoin(DB::raw('backoffice.user as requestor'), function ($join){
                    $join->on('wallet.wallet_setting.requested_by','=' ,DB::raw('CAST(requestor.id as varchar)'));
                  })
                  ->leftJoin(DB::raw('backoffice.user as approver'), function ($join){
                    $join->on('wallet.wallet_setting.approved_by','=' ,DB::raw('CAST(approver.id as varchar)'));
                  })
                  ->selectRaw(
                    'wallet.wallet_setting.id,
                    wallet.wallet_setting.wallet_id,
                    wallet.wallet_setting.fiture,
                    wallet.wallet_setting.status,
                    wallet.wallet_setting.changes,
                    wallet.wallet_setting.requested_by,
                    wallet.wallet_setting.approved_by,
                    wallet.wallet_setting.created_at,
                    wallet.wallet_setting.updated_at,
                    wallet.wallet_setting.document,
                    wallet.wallet_setting.reason,
                    requestor.name as requestor,
                    approver.name as approver'
                  )
                  ->first()
      ;

      return $data;
    }

    public function updateWalletSettingStatus ($id, $data){
      $data = DB::table('wallet.wallet_setting')
                  ->where('id', $id)
                  ->update($data)
      ;

      return $data;
    }

    public function updateWalletLimitByWalletId ($wallet_id, $data){
      $data = DB::table('wallet.wallet_limits')
                  ->where('wallet', $wallet_id)
                  ->update($data);

      return $data;
    }

    public function getWalletSettingHistory ($fiture = null, $wallet_id = null){
      $data = DB::table('wallet.wallet_setting')
                ->leftJoin(DB::raw('backoffice.user as requestor'), function ($join){
                  $join->on('wallet.wallet_setting.requested_by','=' ,DB::raw('CAST(requestor.id as varchar)'));
                })
                ->leftJoin(DB::raw('backoffice.user as approver'), function ($join){
                  $join->on('wallet.wallet_setting.approved_by','=' ,DB::raw('CAST(approver.id as varchar)'));
                })
                ->selectRaw(
                  'wallet.wallet_setting.id,
                  wallet.wallet_setting.wallet_id,
                  wallet.wallet_setting.fiture,
                  wallet.wallet_setting.status,
                  wallet.wallet_setting.changes,
                  wallet.wallet_setting.requested_by,
                  wallet.wallet_setting.approved_by,
                  wallet.wallet_setting.created_at,
                  wallet.wallet_setting.updated_at,
                  wallet.wallet_setting.document,
                  wallet.wallet_setting.reason,
                  requestor.name as requestor,
                  approver.name as approver'
                )
                ->where('wallet.wallet_setting.status', '!=', 2);
      ;

      if (isset($fiture)) {
          $data->where('fiture', $fiture);
      }
      if (isset($wallet_id)) {
          $data->where('wallet_id', $wallet_id);
      }

      return $data;
    }

    public function addTfBlacklist ($data){
      $data = TransferBlacklist::create($data);
      return $data;
    }

    public function addWdBlacklist ($data){
      $data = WithdrawBlacklist::create($data);
      return $data;
    }

    public function addWithdrawFee ($data){
      $data = DB::table('wallet.wallet_withdraw_fee')->insert($data);

      return $data;
    }
}