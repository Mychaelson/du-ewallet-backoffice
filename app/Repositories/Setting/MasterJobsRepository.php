<?php

namespace App\Repositories\Setting;

use App\Models\Setting\MasterJobs;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class MasterJobsRepository
{

    public function index($query){
       $data = DB::table('accounts.jobs')
        ->orderBy('created_at','desc');
      return $data;
    }

    public function create($request){
        $name = ([
            'id'=>$request->nama_pekerjaan,
            'en'=>$request->jobs_name,
        ]);
        $data = new MasterJobs;
        $data->name = json_encode($name);
        $data->type = $request->type;
        $data->save();

        return redirect()->back()->with('message','Add Data Succeessfully');
    }

    public function edit($id){
        $data = DB::table('accounts.jobs')
        ->where('id',$id)
        ->first();

        $new_data = ([
            'id'=> $data->id,
            'name_id'=>json_decode($data->name)->id,
            'name_en'=>json_decode($data->name)->en,
            'type' => $data->type
        ]);

        return $new_data;
    }

    public function edit_process($request){
        $name = ([
            'id'=>$request->nama_pekerjaan,
            'en'=>$request->jobs_name,
        ]);
        $data = MasterJobs::findOrFail($request->req_id);
        $data->name = json_encode($name);
        $data->type = $request->type;
        $data->save();

        return redirect()->route('master-jobs')->with('message','Edit Data Succeessfully');
        }

    public function delete($id){
        $data = DB::table('accounts.jobs')
        ->where('id',$id)
        ->delete();

        return redirect()->back()->with('message','Delete Data Succeessfully');
    }
}
