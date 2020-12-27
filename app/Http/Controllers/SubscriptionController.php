<?php

namespace App\Http\Controllers;

use App\Category;
use App\Events\CancelSubscriptionEvent;
use App\User;

class SubscriptionController extends Controller
{
    public function store($slug, $type)
    {
       return auth()->user()->subscribe($slug, $type);
    }

    public function destroy($slug, $type)
    {
        return auth()->user()->unsubscribe($slug, $type);
    }
}
