<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Location;
use App\Models\AssetTransferHeader;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){

        $userLocation = Auth::user()->LOCATION_ID;

        $receivedTransfer = AssetTransferHeader::where([
            'TRANSFERED_LOCATION_ID' => $userLocation,
            'TRANSFER_STATUS' => 'RECEIVED'
        ])->count();

        $pendingToReceive = AssetTransferHeader::where([
            'TRANSFERED_LOCATION_ID' => $userLocation,
            'TRANSFER_STATUS' => 'TO RECEIVE'
        ])->count();


        $transferedAsset = AssetTransferHeader::where([
            'LOCATION_ID' => $userLocation,
            'TRANSFER_STATUS' => 'RECEIVED'
        ])->count();


        $pendingTransfer = AssetTransferHeader::where([
            'LOCATION_ID' => $userLocation,
            'TRANSFER_STATUS' => 'TO RECEIVE'
        ])->count();

        $getLocations = Location::take(5);
        $locationName = $getLocations->pluck('LOCATION')->toArray();
        $locationID = $getLocations->pluck('LOCATION_ID')->toArray();


        return Inertia::render('HomePage/MainPage',[
            'receivedTransfer' => $receivedTransfer,
            'pendingToReceive' => $pendingToReceive,
            'transferedAsset' => $transferedAsset,
            'pendingTransfer' => $pendingTransfer,
            'locationName' => $locationName,
            'locationID' => $locationID,
        ]);
    }
}
