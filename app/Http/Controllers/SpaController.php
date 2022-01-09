<?php

namespace App\Http\Controllers;

class SpaController extends Controller
{
    public function __invoke()
    {
        return view('spa');
    }
}
