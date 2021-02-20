<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;

class CloudderController extends Controller
{
    public function upload(Request $request)
    {
        $path = User::POST_FILE_PATH . time() . '-' . str_replace('.' . $request->file('file')->getClientOriginalExtension(), "", $request->file('file')->getClientOriginalName());

        $file = Cloudder::upload($request->file('file')->getRealPath(),
            $path,
            [auth()->user()->id . '-' . auth()->user()->email, $request->input('type')]);

        $status = $file->getResult();

        return response()->json([
            'url' => $status['url'],
            'path' => $path
        ]);
    }

    public function destroy(Request $request)
    {
       return response()->json(Cloudder::destroy($request->input('path')));
    }

}
