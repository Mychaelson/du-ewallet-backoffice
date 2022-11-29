<?php

namespace App\Repositories\Promotion;

use Illuminate\Support\Facades\DB;


class CashbackRepository
{
    public function getQuery($request)
    {
        $get_data = DB::table('promotions.ncash_promotion as np')
        ->selectRaw('np.id,np.status,np.name,np.budget,np.max_amount_claim_user,np.created_at');
        $query = $request->input('query');

        if(!empty($query)) {
            if(isset($query['selectStatus'])) {
                $q = $query['selectStatus'];
                $get_data->where('np.status',$q);

            } else if(isset($query['time'])) {
                $time = $request->filled('query') && !empty($query['time']) ? explode('/', $query['time']) : explode('/', \Carbon\Carbon::now()->addHours(-3)->format('Y-m-d H:i:s').'/'.\Carbon\Carbon::now()->format('Y-m-d H:i:s'));
                $time_start = $time[0];
                $time_end = $time[1];
                $get_data->whereRaw("np.created_at >= '$time_start' and np.created_at <= '$time_end'");

            }
        }

        if(isset($request->sort['field'])) {
            $get_data->orderBy($request->sort['field'], $request->sort['sort']);
        } else {
            $get_data->orderBy('np.name', 'desc');
        }

        return $get_data;
    }

    public function getByWhere($where)
    {
        $get_data = DB::table('promotions.ncash_promotion')->where($where);
        
        return $get_data;
    }

    public function getById($id)
    {
        $get_data = DB::table('promotions.ncash_promotion as np')
            ->join('backoffice.user as u','u.id','=','np.created_by')
            ->selectRaw('np.id,np.name,np.budget,np.claim_p_day,np.claim_p_day_user,np.budget_used,np.promo_fund_percentage,np.merch_fund_percentage,np.spread_count, np.max_claim_p_month_user,np.percentage,np.merch_fund_percentage,np.promo_fund_percentage,np.max_amount,np.max_amount_claim_user,np.start_date,np.end_date,np.terms,np.status,np.created_at,u.name as created_by')
            ->where('np.id',$id)
            ->first();

        return $get_data;
    }

    public function save($request)
    {
        // proses insert DB
        $data = DB::table('promotions.ncash_promotion')->insert($request);

        return $data;
    }

    public function update($request,$id)
    {
        // proses Update DB
        $update = DB::table('promotions.ncash_promotion')->where(['id' => $id])->update($request);

        return $update;
    }
    public function deleteById($id)
    {
        // proses Delete DB
        $delete = DB::table('promotions.ncash_promotion')->where(['id' => $id])->delete();

        return $delete;
    }

    public function getCashback($where)
    {
        $get_data = DB::table('promotions.cashback as pc')
        ->join('backoffice.user as u','u.id','=','pc.redeemed_by')
        ->selectRaw('pc.id,pc.amount,pc.transaction_ref,pc.transaction_amount,pc.transaction_id,pc.cashout_at,pc.redeemed_at,u.name as redeemed_by,pc.status')
        ->where($where)->orderBy("pc.updated_at", "desc");

        return $get_data;
    }

    public function getKYCLog($id ,$type)
    {
        $get_data = DB::table('log.kyc_access_log')->selectRaw('id, user, origin, content, type, created')->orderBy("created", "desc");
        if(!empty($id)) {
			$get_data = $get_data->where(['target' => $id ,'type' => $type]);
		}
        return $get_data;
    }

    public function acction_log($data)
    {
        $get_data = DB::table('log.kyc_access_log')->insert($data);

        return $get_data;
    }

}
