<?php

namespace App\Http\Controllers;

use App\Category;

class SubscriptionController extends Controller
{
    public function store($id, $type)
    {
       return auth()->user()->$type()->attach($id);
    }

    public function destroy($id, $type)
    {
       return auth()->user()->$type()->detach($id);
    }
}
