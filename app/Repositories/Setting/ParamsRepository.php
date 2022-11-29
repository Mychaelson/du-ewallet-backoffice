<?php

namespace App\Repositories\Setting;

use App\Models\Setting\Params;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class ParamsRepository
{

    public function index($query)
    {
        $data = DB::table('setting.site_params')
            ->orderBy('created_at', 'desc');
        return $data;
    }

    public function create($request)
    {
        if($request->checks == 1){
            $group = $request->group_two;
        }else{
            $group = $request->group_one;
        }
        $data = new Params;
        $data->name = $request->name;
        $data->group = $group;
        $data->type = $request->type;
        $data->save();

        return redirect()->back()->with('message', 'Add Data Succeessfully');
    }

    public function get_group()
    {
        $data = DB::table('setting.site_params')
            ->select('group')
            ->groupBy('group')
            ->get();

        return $data;
    }

    public function edit($id)
    {
        $data = DB::table('setting.site_params')
            ->where('id', $id)
            ->first();

        return $data;
    }

    public function edit_process($id,$request){
        $data = Params::findOrFail($id);
        $data->name = $request->name;
        $data->group = $request->group;
        $data->value = $request->value;
        $data->save();

        return redirect()->route('params')->with('message', 'Edit Data Succeessfully');
    }

    public function delete($id)
    {
        $data = DB::table('setting.site_params')
            ->where('id', $id)
            ->delete();

        return redirect()->back()->with('message', 'Delete Data Succeessfully');
    }
}
