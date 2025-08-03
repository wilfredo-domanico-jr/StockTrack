<?php

namespace App\Http\Controllers\Admin\BulkLoad;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class BulkLoadController extends Controller
{
    public function index()
    {

        if (Gate::allows('AuthorizeAction', ['ADMIN'])) {


            $user = Auth::user();

            // Check if user is admin or user

            $role = 'user';

            if ($user->ROLE_ID == 1) {
                $role = 'admin';
            }

            // $isUserAdmin = $u
            return Inertia::render('Admin/BulkLoad/Index', [
                'user' => $user,
                'role' => $role
            ]);
        } else {
            return Redirect::route('noAccess');
        }
    }
}
