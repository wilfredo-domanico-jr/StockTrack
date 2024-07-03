<?php

use Inertia\Inertia;
use App\Models\RolePermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

function getActiveRole(){
    $activeRole = DB::table('users_list_of_role as A')->where('A.id',auth()->user()->ACTIVE_ROLE)
                    ->leftJoin('users_role as B','A.ROLE_ID','B.id')
                    ->leftJoin('location as C','A.LOCATION_ID','C.LOCATION_ID')
                    ->where('C.DELETED',0)
                    ->where('B.DELETED',0)
                    ->first() ;

   return $activeRole;
}

function globalLocation(){
    return "000000";
}







