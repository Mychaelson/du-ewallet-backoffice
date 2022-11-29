<?php

namespace App\Repositories\Setting;

use App\Models\Role;
use App\Models\Setting\Module;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class MasterRoleRepository
{

    public function index($query)
    {
        $data = DB::table('backoffice.roles');
        return $data;
    }


    public function get_menu()
    {
        $data = Module::with('child')
        ->where('parent_id',0)
        ->get();

    //    ->where('parent_id',0)


        return $data;
    }

    public function store($request)
    {
        if ($request->view == null) {
            $view = '';
        } else {
            $array_view = implode(',', $request->view);
            $view = str_replace(['"'], "", $array_view);
        }

        if ($request->create == null) {
            $create = '';
        } else {
            $array_create = implode(',', $request->create);
            $create = str_replace(['"'], "", $array_create);
        }

        if($request->alter == null){
            $alter ='';
        }else{
            $array_alter = implode(',', $request->alter);
            $alter = str_replace(['"'], "", $array_alter);
        }

        if($request->drop == null){
            $drop ='';
        }
        else{
            $array_drop = implode(',', $request->drop);
            $drop = str_replace(['"'], "", $array_drop);
        }
        $array = '{"view":"' . $view . '","create":"' . $create . '","alter":"' . $alter . '","drop":"' . $drop . '"}';

        $get_id = DB::table('backoffice.role')
        ->orderBy('id','desc')
        ->first();
        $data = new Role;
        $data->id=$get_id->id + 1;
        $data->name = $request->name;
        $data->role = $array;
        $data->save();

        return redirect()->route('master-role')->with('message', 'Add Data Succeessfully');
    }

    public function edit($id)
    {
        $data = DB::table('backoffice.roles')
            ->where('id', $id)
            ->first();

        return $data;
    }

    public function get_role($id){
        $data = DB::table('backoffice.roles')
        ->where('id', $id)
        ->first();

       $get =[];
       $set = array_map('intval', explode(',', json_decode($data->role)->view));

        return count($set);
    }

    public function edit_process($request,$id)
    {
        if ($request->view == null) {
            $view = '';
        } else {
            $array_view = implode(',', $request->view);
            $view = str_replace(['"'], "", $array_view);
        }

        if ($request->create == null) {
            $create = '';
        } else {
            $array_create = implode(',', $request->create);
            $create = str_replace(['"'], "", $array_create);
        }

        if($request->alter == null){
            $alter ='';
        }else{
            $array_alter = implode(',', $request->alter);
            $alter = str_replace(['"'], "", $array_alter);
        }

        if($request->drop == null){
            $drop ='';
        }
        else{
            $array_drop = implode(',', $request->drop);
            $drop = str_replace(['"'], "", $array_drop);
        }
        $array = '{"view":"' . $view . '","create":"' . $create . '","alter":"' . $alter . '","drop":"' . $drop . '"}';

        $data = Role::findOrFail($id);
        $data->name = $request->name;
        $data->role = $array;
        $data->save();

        return redirect()->route('master-role')->with('message', 'Add Data Succeessfully');
    }

    public function delete($id)
    {
        $data = DB::table('backoffice.roles')
            ->where('id', $id)
            ->delete();

        return redirect()->back()->with('message', 'Delete Data Succeessfully');
    }
}
