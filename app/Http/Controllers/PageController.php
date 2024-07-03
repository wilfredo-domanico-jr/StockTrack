<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function notfound(){

        return Inertia::render('Errors/404',[]);
    }


    public function noAccess(){

        return Inertia::render('Errors/403',[]);
    }

}
