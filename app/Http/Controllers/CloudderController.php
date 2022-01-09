<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyImageRequest;
use App\Http\Requests\UploadImageRequest;
use App\Models\User;
use JD\Cloudder\Facades\Cloudder;

class CloudderController extends Controller
{
    public function upload(UploadImageRequest $request)
    {
        $path = User::POST_FILE_PATH . time() . '-' . str_replace('.' . $request->file->getClientOriginalExtension(), "", $request->file('file')->getClientOriginalName());

        $file = Cloudder::upload($request->file->getRealPath(),
            $path,
            [auth()->user()->id . '-' . auth()->user()->email, $request->input('type')]);

        $status = $file->getResult();

        return response()->json([
            'url' => $status['url'],
        ]);
    }

    public function destroy(DestroyImageRequest $request)
    {
        return response()->json(Cloudder::destroy($request->path));
    }
}
