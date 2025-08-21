<?php

use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

function getUserRole()
{
    return Auth::user()->ROLE_ID;
}


function getUserLocation()
{
    return Auth::user()->LOCATION_ID;
}


function getUserInventoryCount()
{
    $userLocation = getUserLocation();

    $count = Inventory::where(['LOCATION_ID' => $userLocation])->count();

    return $count;
}
