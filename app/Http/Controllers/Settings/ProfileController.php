<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use JD\Cloudder\Facades\Cloudder;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
        ]);

        return tap(auth()->user())->update([
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
        ]);
    }

    public function avatarUpdate(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required',
        ]);

        $avatar = Cloudder::upload($request->file('avatar')->getRealPath(),
            User::AVATAR_PATH . time() . '-' . str_replace('.' . $request->file('avatar')->getClientOriginalExtension(), "", $request->file('avatar')->getClientOriginalName()),
            [],
            auth()->user()->id . '-' . auth()->user()->name);

        $avatar_status = $avatar->getResult();

        return tap(auth()->user())->update([
            'avatar' => $avatar_status['url']
        ]);
    }

    public function headerUpdate(Request $request)
    {
        $this->validate($request, [
            'header' => 'required',
        ]);

        $user = auth()->user();

        $header = Cloudder::upload($request->file('header')->getRealPath(),
            User::HEADER_PATH . time() . '-' . str_replace('.' . $request->file('header')->getClientOriginalExtension(), "", $request->file('header')->getClientOriginalName()),
            [],
            $user->id . '-' . $user->name);

        $header_status = $header->getResult();

        return tap(auth()->user())->update([
            'header' => $header_status['url']
        ]);
    }

    public function headerDestroy()
    {
        auth()->user()->update(['header' => null]);

        return response()->json();
    }
}
