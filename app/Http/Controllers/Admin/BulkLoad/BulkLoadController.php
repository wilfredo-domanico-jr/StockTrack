<?php

namespace App\Http\Controllers\Admin\BulkLoad;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class BulkLoadController extends Controller
{
    public function index(){

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {

            $user = Auth::user();
        return Inertia::render('Admin/BulkLoad/Index',[
            'user' => $user,
        ]);
        } else {
            return Redirect::route('noAccess');
        }


    }
}
