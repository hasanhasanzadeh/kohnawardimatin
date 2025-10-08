<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhotoRequest;
use App\Models\File;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{



    public function store(PhotoRequest $request): JsonResponse
    {
        $uploadedFile = $request->file('file');
        $filename =time().$uploadedFile->getClientOriginalName();
        Storage::disk('local')->putFileAs(
            'public/uploads/photo', $uploadedFile, $filename
        );
        $photo =new File();
        $photo->path =$filename;
        $photo->save();
        toast(__('dashboard.success'),'success');
        return response()->json(['photo_id'=>$photo->id]);
    }

    public function uploadImage(Request $request): void
    {
        if ($request->hasFile('upload')) {
            $uploadedFile = $request->file('upload');
            $filename = time() . $uploadedFile->getClientOriginalName();
            $original_name = $uploadedFile->getClientOriginalName();
            Storage::disk('local')->putFileAs(
                'public/uploads/images', $uploadedFile, $filename
            );
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = ENV('APP_URL') . '/storage/uploads/images/' . $filename;

            $msg = __('dashboard.success');
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

}
