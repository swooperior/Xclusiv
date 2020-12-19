<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function restricted(){
        return view('errors.restricted');
    }
}
