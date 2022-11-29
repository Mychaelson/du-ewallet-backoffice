<?php

namespace App\Repositories\Report;

use App\Models\Documents\Document;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Report\Report;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ReportRepository
{

    public function index(){
        $data = DB::table('backoffice.report')
        ->leftJoin('backoffice.user','backoffice.user.id','=','backoffice.report.user','backoffice.report.used_by')
        ->select('backoffice.user.name','backoffice.report.subject','backoffice.report.number','backoffice.report.used_by','backoffice.report.user','backoffice.report.created_at','backoffice.report.id');

      return $data;
    }

    public function reportNotUser(){
        $data = DB::table('backoffice.report')
        ->leftJoin('backoffice.user','backoffice.user.id','=','backoffice.report.user','backoffice.report.used_by')
        ->select('backoffice.user.name','backoffice.report.subject','backoffice.report.number','backoffice.report.used_by','backoffice.report.user','backoffice.report.created_at','backoffice.report.id')
        ->WhereNull('backoffice.report.used_by');

      return $data;
    }

    public function reportUsed(){
        $data = DB::table('backoffice.report')
        ->Where('used_by', 1);

      return $data->count();
    }

    public function reportNotExist($numberDoc){
        $data = DB::table('backoffice.report')
        ->Where('number', $numberDoc);

      return $data->count();
    }



    public function store($request){
        $user = auth('sanctum')->user()->id;

        $add = new Report;
        $add->user = $user;
        $add->subject = $request->subject;
        $add->number = $request->number;
        $add->contents = $request->content;
        if($request->file('image')){
            $get_file = $request->file('image');
            $name = Str::random(40);
            $extension = $get_file->getClientOriginalExtension();
            Storage::disk('s3')->put($name, file_get_contents($get_file));
            $file =  'http://siapbayar-dev.s3.ap-southeast-3.amazonaws.com/' . $name;
            $add->attachements=$file;
            }
        $add->save();

        return redirect()->route('report.index')->with('message','Add Data successfully');
    }


    public function edit($id){
        $data = DB::table('backoffice.report')
            ->where('id',$id)
            ->first();

            return $data;
    }

    public function update($request,$id){

        $add = Report::findOrFail($id);
        $add->subject = $request->subject;
        $add->number = $request->number;
        $add->contents = $request->content;

        if($request->file('image')){
            $get_file = $request->file('image');
            $name = Str::random(40);
            $extension = $get_file->getClientOriginalExtension();
            Storage::disk('s3')->put($name, file_get_contents($get_file));
            $file =  'http://siapbayar-dev.s3.ap-southeast-3.amazonaws.com/' . $name;

            $add->attachements=$file;
        }

        $add->save();

        return redirect()->route('report.index')->with('message','Edit Data successfully');
    }

    public function delete($id){
        DB::table('backoffice.report')
        ->where('id',$id)
        ->delete();

        return redirect()->route('report.index')->with('message','Delete Data successfully');

    }

    public function updateDocumentInfo($documentNumber, $info)
    {
        $data = DB::table('backoffice.report')
                    ->where('number', $documentNumber)
                    ->update($info);
        
        return $data;
    }
}
