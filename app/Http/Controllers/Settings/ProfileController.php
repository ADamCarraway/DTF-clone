<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
        ]);

        return tap(auth()->user())->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
    }

    public function avatarUpdate(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required',
        ]);

        $avatar = Cloudder::upload($request->file('avatar')->getRealPath(),
            User::AVATAR_PATH . $request->file('avatar')->getClientOriginalName(), [], auth()->user()->id.'-'.auth()->user()->name);

        $avatar_status = $avatar->getResult();

        return tap(auth()->user())->update([
            'avatar' => $avatar_status['url']
        ]);
    }
}
