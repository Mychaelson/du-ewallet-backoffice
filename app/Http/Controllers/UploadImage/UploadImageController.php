<?php

namespace App\Http\Controllers\UploadImage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Library\Services\Datatables;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
{
    
    public function uploadImageS3(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'file' => 'required|mimes:webp,jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip,txt|max:2048',
        ]);


        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'response_code' => 200,
                'message' => 'Error validation',
                'data' => $validation->errors()
            ]);
        }
        try {
            $hashfilename = str_random(30);
            
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filesize = 0;
            $filename = 'images/'.$hashfilename . '.' . $extension;

                $path = Storage::disk('s3')->put($filename, file_get_contents($file));
                $path = Storage::disk('s3')->url($path);
                $filePath = config('filesystems.disks.s3.url') . $filename;
                $url = $filePath;

            return response()->json([
                'success' => true,
                'response_code' => 200,
                'message' => 'success upload',
                'data' => $url
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response_code' => 200,
                'message' => 'upload failed',
                'data' => $e->getMessage()
            ]);
        }
    }
}
