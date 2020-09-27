<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubsNotify;
use App\User;
use Illuminate\Http\Request;

class SubsNotifyController extends Controller
{
    public function store($type, $id)
    {
        return auth()->user()->subsNotify()->create([
            'user_id' => auth()->id(),
            'subs_notify_type' => SubsNotify::$types[$type],
            'subs_notify_id' => $id
        ]);
    }

    public function destroy($type, $id)
    {
        return auth()->user()->subsNotify()->where([
            'user_id' => auth()->id(),
            'subs_notify_type' => SubsNotify::$types[$type],
            'subs_notify_id' => $id
        ])->delete();
    }
}
