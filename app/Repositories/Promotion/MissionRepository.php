<?php

namespace App\Repositories\Promotion;

use Illuminate\Support\Facades\DB;

class MissionRepository
{
    public function getQuery($request,$where)
    {
        $get_data = DB::table('memberships.provider_catalogue as pc')
        ->join('backoffice.user as u','u.id','=','pc.created_by')
        ->selectRaw('pc.id,pc.name,pc.status,pc.type,pc.slug,pc.description,pc.redemption_note,pc.images,
        pc.created_by,pc.partner_id,pc.item_value,pc.extra_pay,pc.start_at,pc.end_at,pc.point,
        pc.exchange_date_limit,pc.created_at')
        ->where($where);
        $query = $request->input('query');
        if(!empty($query)) {
            if(isset($query['selectStatus'])) {
                $q = $query['selectStatus'];
                $get_data->where('pc.status',$q);

            } else if(isset($query['time'])) {
                $time = $request->filled('query') && !empty($query['time']) ? explode('/', $query['time']) : explode('/', \Carbon\Carbon::now()->addHours(-3)->format('Y-m-d H:i:s').'/'.\Carbon\Carbon::now()->format('Y-m-d H:i:s'));
                $time_start = $time[0];
                $time_end = $time[1];
                $get_data->whereRaw("pc.created_at >= '$time_start' and pc.created_at <= '$time_end'");

            }
        }

        if(isset($request->sort['field'])) {
            $get_data->orderBy($request->sort['field'], $request->sort['sort']);
        } else {
            $get_data->orderBy('pc.name', 'desc');
        }

        return $get_data;
    }

    public function getProvider()
    {
        $data = DB::table('memberships.provider')->selectRaw('id,code,name,slug');

        return $data;
    }

    public function getCategory()
    {
        $data = DB::table('memberships.category')->selectRaw('id,name,slug');

        return $data;
    }

    public function getById($id)
    {
        $get_data = DB::table('memberships.provider_catalogue as pc')
            ->join('backoffice.user as u','u.id','=','pc.created_by')
            ->selectRaw('u.name as created_by,pc.id,pc.name,pc.status,pc.type,pc.slug,pc.description,pc.redemption_note,pc.images,
            pc.partner_id,pc.item_value,pc.extra_pay,pc.start_at,pc.end_at,pc.quantity,pc.terms,pc.coupon_as_payment,pc.point,
            pc.exchange_date_limit,pc.created_at,pc.product,pc.provider_id,pc.category')
            ->where('pc.id',$id)
            ->first();

        return $get_data;
    }

    public function save($params)
    {
        // proses insert DB
        $data = DB::table('memberships.provider_catalogue')->insertGetId($params);

        return $data;
    }

    public function update($params,$id)
    {
        // proses Update DB
        $data = DB::table('memberships.provider_catalogue')->where(['id' => $id])->update($params);

        return $data;
    }
    public function delete($id)
    {
        // proses Delete DB
        $delete = DB::table('memberships.provider_catalogue')->where(['id' => $id])->delete();

        return $delete;
    }


    public function getTotalMission($where,$group){
        $data = DB::table('memberships.missions')->selectRaw('count(*) as data')->where($where)->groupBy($group)->first();
		return $data;
	}

	public function getTotalMA($where,$group){
        $data = DB::table('memberships.missions_achievement')->selectRaw('count(*) as data')->where($where)->groupBy($group)->first();
		return $data;
	}

	public function getCompleteMission($where){
        $data = DB::table('memberships.missions_achievement')->selectRaw('count(*) as data')->where($where)->whereRaw('missions_achievement.coupon_id is not null')->groupBy('coupon_id')->first();
		return $data;
	}

    public function getKYCLog($id ,$type)
    {
        $get_data = DB::table('log.kyc_access_log')->selectRaw('id, user, origin, content, type, created')->orderBy("created", "desc");
        if(!empty($id)) {
			$get_data = $get_data->where(['target' => $id ,'type' => $type]);
		}
        return $get_data;
    }
    
    function getlist_mission($id){
        $get_data = DB::table('memberships.missions')->where(['deleted_at'=> null,'catalogue_id' => $id]);
		return $get_data;
	}

    public function insertM($data)
    {
        $get_data = DB::table('memberships.missions')->insert($data);
		return $get_data;
    }
    
    public function getMById($id)
    {
        $get_data = DB::table('memberships.missions')->where(['id' => $id]);
		return $get_data;
    }

    public function updateM($id,$data)
    {
        $get_data = DB::table('memberships.missions')->where(['id' => $id])->update($data);
		return $get_data;
    }

    public function deleteM($id)
    {
        $get_data = DB::table('memberships.missions')->where(['id' => $id])->delete();
		return $get_data;
    }

    public function acction_log($data)
    {
        $get_data = DB::table('log.kyc_access_log')->insert($data);

        return $get_data;
    }
}
