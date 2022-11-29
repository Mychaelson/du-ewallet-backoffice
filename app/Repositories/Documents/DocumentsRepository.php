<?php

namespace App\Repositories\Documents;

use App\Models\Documents\Document;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Validator;
class DocumentsRepository
{

    public function index($query){
        $data = DB::table('backoffice.document')
        ->join('backoffice.user','backoffice.user.id','=','backoffice.document.user')
        ->select('backoffice.user.name','backoffice.document.title','backoffice.document.locale','backoffice.document.content','backoffice.document.version','backoffice.document.created_at','backoffice.document.id')
        ->orderBy('backoffice.document.created_at','desc');

        return $data;

    }

    public function index_dt($query){

    }

    public function store($request){
        $request->validate([
            'content' => 'required',
        ]);

        $user = auth('sanctum')->user()->id;
        $data = new Document;
        $data->title = $request->title;
        $data->slug = $request->slug;
        $data->user = $user;
        $data->locale = $request->locale;
        $data->version = $request->version;
        $data->content = $request->content;

        $data->save();

        return redirect()->route('docs.index')->with('message','data added successfully');
    }

    public function edit($id){
        $data = DB::table('backoffice.document')
        ->where('id',$id)
        ->first();

        return $data;

    }
    public function update($id,$request){
        $request->validate([
            'content' => 'required',
        ]);
        
        $user = auth('sanctum')->user()->id;
        $data =  Document::findOrFail($id);
        $data->title = $request->title;
        $data->slug = $request->slug;
        $data->user = $user;
        $data->locale = $request->locale;
        $data->version = $request->version;
        $data->content = $request->content;

        $data->save();

        return redirect()->route('docs.index')->with('message','Edit Data successfully');
    }

    public function destory($id){
        DB::table('backoffice.document')
        ->where('id',$id)
        ->delete();

        return redirect()->route('docs.index')->with('delete','Delete data successfully');

    }
}


?>
