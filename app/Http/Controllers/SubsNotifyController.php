<?php

namespace App\Http\Controllers;

class SubsNotifyController extends Controller
{
    public function store($type, $id)
    {
        return auth()->user()->$type()->attach($id);
    }

    public function destroy($type, $id)
    {
        return auth()->user()->$type()->detach($id);
    }
}
