<?php

namespace App\Repositories\Media;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Models\Media\Media;
class MediaRepository
{

    public function get_image($query)
    {
        $data = DB::table('accounts.media')
        ->where('group_id',5)
        ->orderBy('created_at','desc');
        return $data;
    }

    public function upload($request){
        $user = auth('sanctum')->user()->id;
        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $hashfilename = Str::random(40);
                $res_name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $res_mimetype = $file->getClientMimeType();
                $res_size = $file->getSize();
                $res_hashname = $hashfilename . '.' . $extension;
                $filename =  $hashfilename . '.' . $extension;
                $res_extension = $extension;
                $path = Storage::disk('s3')->put($filename, file_get_contents($file));
                $res_url= 'http://siapbayar-dev.s3.ap-southeast-3.amazonaws.com/' . $hashfilename . '.' . $extension;

                $add = new Media;
                $add->filename=$res_hashname;
                $add->extension=$res_extension;
                $add->mimetype=$res_mimetype;
                $add->filesize=$res_size;
                $add->filepath=$res_url;
                $add->url=$res_url;
                $add->user_id=$user;
                $add->disk='cloud';
                $add->type='';
                $add->name=$res_name;
                $add->group_id=5;

                $add->save();

            }
        }
        return redirect()->back()->with('message','Add Data Successfully');

    }

}
