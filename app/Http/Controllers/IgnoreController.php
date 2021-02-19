<?php

namespace App\Http\Controllers;

use App\Http\Requests\IgnoreRequest;

class IgnoreController extends Controller
{
    public function store(IgnoreRequest $request)
    {
       return auth()->user()->startIgnore($request->ignorable());
    }

    public function destroy(IgnoreRequest $request)
    {
       return auth()->user()->stopIgnore($request->ignorable());
    }
}
