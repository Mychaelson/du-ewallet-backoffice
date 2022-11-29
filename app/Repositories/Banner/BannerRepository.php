<?php

namespace App\Repositories\Banner;

use Illuminate\Support\Facades\DB;

class BannerRepository
{
    public function getBannerQuery($query)
    {
        $get_data = DB::table('banner.banners')
        ->selectRaw('id,title,activity,status,created_at');

        $get_data->orderBy('banners.created_at', 'desc');
        
        return $get_data;
    }

    public function getActivityQuery()
    {
        $activity = DB::table('banner.banner_catergory')
        ->selectRaw('name')
        ->get();
        
        return $activity;
    }

    public function getBannerById($id)
    {
        $get_data = DB::table('banner.banners')
            ->selectRaw('id,title,terms,highlight,image,cover,time_start,time_end,activity,label,phone,banners.group,web,email,params')
            ->where('id',$id)
            ->first();

        return $get_data;
    }

    public function saveBanner($request)
    {
        $japar = $this->getParams($request->params);
        $str_param = json_encode($japar);
        $params = [
            'title' => $request->title,
            'terms' => $request->terms,
            'highlight' => $request->highlight,
            'image' => $request->image,
            'cover' => $request->cover,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'activity' => $request->activity,
            'label' => $request->label,
            'phone' => $request->phone,
            'group' => $request->group,
            'web' => $request->web,
            'email' => $request->email,
            'params' => $str_param,
            'created_at' => now(),
            'updated_at' => now()
        ];

        // proses insert DB
        $data = DB::table('banner.banners')->insert($params);

        return $data;
    }

    public function updateBanner($request)
    {
        $japar = $this->getParams($request->params);
        $str_param = json_encode($japar);
        $params = [
            'title' => $request->title,
            'terms' => $request->terms,
            'highlight' => $request->highlight,
            'image' => $request->image,
            'cover' => $request->cover,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'activity' => $request->activity,
            'label' => $request->label,
            'phone' => $request->phone,
            'group' => $request->group,
            'web' => $request->web,
            'email' => $request->email,
            'params' => $str_param,
            'updated_at' => now()
        ];

        // proses Update DB
        $update = DB::table('banner.banners')->where(['id' => $request->id])->update($params);

        return $update;
    }
    public function deleteBanner($id)
    {
        // proses Delete DB
        $delete = DB::table('banner.banners')->where(['id' => $id])->delete();

        return $delete;
    }

    public function getParams($params)
    {
        $japar = array();
        if(!empty($params)){
            $jparam = explode("\n", str_replace("\r", "", $params));
            if(count($jparam) > 0){
                foreach($jparam as $jpar){
                    $ddpar = explode(":", $jpar);
                    if(count($ddpar) > 0){
                            $japar[trim($ddpar[0])] = trim($ddpar[1]);
                    }else $japar[] = trim($jpar);
                }
            }
        }

        return $japar;
    }
}
