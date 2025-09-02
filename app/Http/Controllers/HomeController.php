<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransferHeader;
use Inertia\Inertia;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        $userLocation = Auth::user()->LOCATION_ID;

        $receivedTransfer = InventoryTransferHeader::where([
            'TRANSFERED_LOCATION_ID' => $userLocation,
            'TRANSFER_STATUS' => 'RECEIVED'
        ])->count();

        $pendingToReceive = InventoryTransferHeader::where([
            'TRANSFERED_LOCATION_ID' => $userLocation,
            'TRANSFER_STATUS' => 'TO RECEIVE'
        ])->count();


        $transferedProduct = InventoryTransferHeader::where([
            'LOCATION_ID' => $userLocation,
            'TRANSFER_STATUS' => 'RECEIVED'
        ])->count();


        $pendingTransfer = InventoryTransferHeader::where([
            'LOCATION_ID' => $userLocation,
            'TRANSFER_STATUS' => 'TO RECEIVE'
        ])->count();

        $getLocations = Location::take(5);
        $locationName = $getLocations->pluck('LOCATION')->toArray();
        $locationID = $getLocations->pluck('LOCATION_ID')->toArray();


        return Inertia::render('HomePage/MainPage', [
            'receivedTransfer' => $receivedTransfer,
            'pendingToReceive' => $pendingToReceive,
            'transferedProduct' => $transferedProduct,
            'pendingTransfer' => $pendingTransfer,
            'locationName' => $locationName,
            'locationID' => $locationID,
        ]);
    }
}
