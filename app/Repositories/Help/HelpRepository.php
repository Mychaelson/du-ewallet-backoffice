<?php

namespace App\Repositories\Help;

use App\Models\Documents\Document;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Help\Help;
use App\Models\Help\HelpCategory;
use Auth;
class HelpRepository
{


    public function index($req,$id){
        $data = DB::table('backoffice.help')
         ->where('category',$id)
         ->where('title','LIKE',"%$req%")
         ->orderBy('created_at','desc')
         ->paginate(10);

         return $data;
    }

    public function category($id){
        $data = DB::table('backoffice.help_category')
        ->where('id',$id)
        ->first();

        return $data;
    }

    public function index_category($query){
        $data = DB::table('backoffice.help_category')
        ->orderBy('created_at','desc');
        return $data;
    }


    public function create($id){
         $data = DB::table('backoffice.help_category')
         ->where('id',$id)
         ->first();
        return $data;
    }


    public function store($request){
        $keywords_array = explode(',', $request->keywords);
        $keywords = json_encode($keywords_array);

        $user = auth('sanctum')->user()->id;
        $data = new Help;
        $data->user = $user;
        $data->category = $request->category;
        $data->locale = $request->locale;
        $data->group = $request->group;
        $data->title = $request->title;
        $data->content = $request->content;
        $data->keywords = $keywords;
        $data->save();

        return redirect()->route('index-by-category',['id'=>$request->category])->with('message','data added successfully');
    }


    public function edit($id){
        $data = DB::table('backoffice.help')
        ->where('id',$id)
        ->first();
        return $data;
    }

    public function update($request,$id){
        $keywords_array = explode(',', $request->keywords);
        $keywords = json_encode($keywords_array);

        $user = auth('sanctum')->user()->id;
        $data = Help::findOrFail($id);
        $data->user = $user;
        $data->category = $request->category;
        $data->locale = $request->locale;
        $data->group = $request->group;
        $data->title = $request->title;
        $data->content = $request->content;
        $data->keywords = $keywords;
        $data->save();

        return redirect()->route('index-by-category',['id'=>$request->category])->with('message','Edit Data successfully');
    }

    public function destory($id){
        DB::table('backoffice.help')
         ->where('id',$id)
         ->delete();

        return redirect()->back()->with('delete','Delete data successfully');

    }
}


?>
