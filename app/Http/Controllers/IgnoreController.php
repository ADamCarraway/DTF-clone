<?php

namespace App\Http\Controllers;

class IgnoreController extends Controller
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
