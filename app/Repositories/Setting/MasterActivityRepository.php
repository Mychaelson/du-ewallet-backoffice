<?php

namespace App\Repositories\Setting;

use App\Models\Setting\MasterActivity;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class MasterActivityRepository
{

    public function index($query){
       $data = DB::table('backoffice.user_perms')
        ->orderBy('created_at','desc');
      return $data;
    }

    public function create($request){
        $data = new MasterActivity;
        $data->name = $request->name;
        $data->group = $request->group;
        $data->role = $request->role;
        $data->about = $request->about;
        $data->save();

        return redirect()->back()->with('message','Add Data Succeessfully');
    }

    public function edit($id){
        $data = DB::table('backoffice.user_perms')
        ->where('id',$id)
        ->first();

        return $data;
    }

    public function edit_process($request){
        $data = MasterActivity::findOrFail($request->id);
        $data->name = $request->name;
        $data->group = $request->group;
        $data->role = $request->role;
        $data->about = $request->about;
        $data->save();

        return redirect()->back()->with('message','Edit Data Succeessfully');
    }

    public function delete($id){
        $data = DB::table('backoffice.user_perms')
        ->where('id',$id)
        ->delete();

        return redirect()->back()->with('message','Delete Data Succeessfully');
    }
}
