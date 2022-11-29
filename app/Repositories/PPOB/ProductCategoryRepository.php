<?php

namespace App\Repositories\PPOB;

use App\Models\PPOB\ProductCategory;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategoryRepository
{

    public function get_category(){
        $data = ProductCategory::with('child')
        ->where('parent_id',0);

        return $data;
    }

    public function get_parent(){
        $data = ProductCategory::with('child')
        ->where('parent_id',0)
        ->get();
        return $data;
    }

    public function store($request){
        $get_id = DB::table('ppob.digital_categories')
            ->orderBy('id','desc')
            ->first();

        $data = new ProductCategory;
        $data->id = $get_id->id +1;
        $data->name = $request->name;
        $data->slug =  $request->slug;
        $data->description = $request->description;
        $data->status = $request->status;
        $data->group = $request->group;
        $data->parent_id = $request->parent;
        if($request->file('image')){
            $get_file = $request->file('image');
            $name = Str::random(40);
            $extension = $get_file->getClientOriginalExtension();
            Storage::disk('s3')->put($name, file_get_contents($get_file));
            $file =  'http://siapbayar-dev.s3.ap-southeast-3.amazonaws.com/' . $name;
            $data->image=$file;
            }

        $data->save();

        return redirect()->route('product_category');
    }

    public function edit($id){
        $data = DB::table('ppob.digital_categories')
        ->where('id',$id)
        ->first();

        return $data;
    }

    public function update($request,$id){
        $data = ProductCategory::findOrFail($id);
        $data->name = $request->name;
        $data->slug =  $request->slug;
        $data->description = $request->description;
        $data->status = $request->status;
        $data->group = $request->group;
        $data->parent_id = $request->parent;
        if($request->image !== null){
        if($request->file('image')){
            $get_file = $request->file('image');
            $name = Str::random(40);
            $extension = $get_file->getClientOriginalExtension();
            Storage::disk('s3')->put($name, file_get_contents($get_file));
            $file =  'http://siapbayar-dev.s3.ap-southeast-3.amazonaws.com/' . $name;
            $data->image=$file;
            }
        }else{
            $data->image = $request->image_old;
        }
        $data->save();

        return redirect()->route('product_category');
    }

    public function delete($id){
        $data = DB::table('ppob.digital_categories')
        ->where('id',$id)
        ->delete();

        return redirect()->route('product_category');
    }
}
