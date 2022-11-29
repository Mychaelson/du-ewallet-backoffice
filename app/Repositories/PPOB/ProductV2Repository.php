<?php

namespace App\Repositories\PPOB;

use App\Models\PPOB\product_v2;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;

class ProductV2Repository
{
    public function get_product($query){
        $data = DB::table('ppob.product_v2')
        ->when($query->code, fn ($query, $code) => $query->where('code', 'LIKE',"%$code%"))
        ->when($query->status, fn ($query, $status) => $query->where('status',$status))
        ->orderBy('created_at','desc');

        return $data;
    }

    public function detail($code){
        $data = DB::table('ppob.product_v2 as pv')
        ->leftJoin('ppob.digital_categories as ds','ds.id','=','pv.category_id')
        ->leftJoin('ppob.service_v2 as sv','sv.id','=','pv.service_id')
        ->select('pv.code','pv.name','pv.description','pv.provider','pv.denom','pv.price_sell','pv.price_buy','pv.admin_fee','pv.discount','pv.status','pv.created_at','pv.product_type','ds.name as category_name','sv.name as name_service')
        ->where('pv.code',$code)
        ->first();

        return $data;
    }

    public function detail_product($code){
        $data = DB::table('ppob.product_v2')
        ->where('code',$code)
        ->first();

        return $data;

    }

    public function get_all_product(){
        $data = DB::table('ppob.product_v2')
            ->get();

            return $data;
    }

    public function service($code){
        $data = DB::table('ppob.product_services')
        ->join('ppob.service_v2','ppob.service_v2.id','=','ppob.product_services.service_id')
        ->where('product_code',$code)
        ->select('ppob.service_v2.name as name_service','ppob.product_services.service_id','ppob.product_services.product_code','ppob.product_services.base_price')
        ->get();

       return $data;
    }

    public function update($request , $code){

        $get_price = DB::table('ppob.product_services')
        ->where('product_code','=',$code)
        ->where('service_id',$request->service)
        ->first();
        $get_id = DB::table('ppob.product_v2')
        ->where('code','=',$code)
        ->first();

        $id = $get_id->id;

        $data = product_v2::findOrFail($get_id->id);
        $data->name = $request->name;
        $data->slug = $request->slug;
        $data->price_buy = $get_price->base_price;
        $data->price_sell = $request->price_sell;
        $data->service_id = $request->service;
        $data->description = $request->description;
        $data->save();

        return redirect()->back();
    }
}
