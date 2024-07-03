<?php

namespace App\Http\Controllers\Inventory;

use Inertia\Inertia;
use App\Models\Location;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use App\Models\AssetTransferHeader;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use App\Models\AssetTransferAssetDetail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as HttpRequest;

class AssetTransferController extends Controller
{

    public function index()
    {


        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {

            $search = Request::input('search');
            $assetTransfers = AssetTransferHeader::select(
                'ASSET_TRANSFER_NO',
                'TRANSACTION_DATE',
                'TRANSFERED_LOCATION_ID',
                'LOCATION_ID',
                'DATE_RECEIVED',
                'TRANSFER_STATUS'
            )->where([
                'LOCATION_ID' => Auth::user()->LOCATION_ID,
                'TRANSFER_STATUS' => 'TO RECEIVE',
            ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('ASSET_TRANSFER_NO', 'like', "%{$search}%")
                      ->orWhere('TRANSACTION_DATE', 'like', "%{$search}%")
                      ->orWhere('TRANSFERED_LOCATION_ID', 'like', "%{$search}%")
                      ->orWhere('LOCATION_ID', 'like', "%{$search}%")
                      ->orWhere('DATE_RECEIVED', 'like', "%{$search}%")
                      ->orWhere('TRANSFER_STATUS', 'like', "%{$search}%");
                });
            })
            ->paginate(10)->withQueryString();

            return Inertia::render('Inventory/AssetTransfer/Index', [
                'assetTransfers' => $assetTransfers,
                'filters' => Request::only(['search']),
            ]);

        } else {
            return Redirect::route('noAccess');
        }

    }

    public function history()
    {

        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {

            $search = Request::input('search');
            $assetTransfers = AssetTransferHeader::select(
                'ASSET_TRANSFER_NO',
                'TRANSACTION_DATE',
                'TRANSFERED_LOCATION_ID',
                'LOCATION_ID',
                'DATE_RECEIVED',
                'TRANSFER_STATUS'
            )->where([
                'LOCATION_ID' => Auth::user()->LOCATION_ID
            ])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('ASSET_TRANSFER_NO', 'like', "%{$search}%")
                      ->orWhere('TRANSACTION_DATE', 'like', "%{$search}%")
                      ->orWhere('TRANSFERED_LOCATION_ID', 'like', "%{$search}%")
                      ->orWhere('LOCATION_ID', 'like', "%{$search}%")
                      ->orWhere('DATE_RECEIVED', 'like', "%{$search}%")
                      ->orWhere('TRANSFER_STATUS', 'like', "%{$search}%");
                });
            })
            ->paginate(10)->withQueryString();

            return Inertia::render('Inventory/AssetTransfer/History', [
                'assetTransfers' => $assetTransfers,
                'filters' => Request::only(['search']),
            ]);

        } else {
            return Redirect::route('noAccess');
        }

    }


    public function create()
    {

        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {
            $locations = Location::all();
            $userLocation = Auth::user()->LOCATION_ID;
            return Inertia::render('Inventory/AssetTransfer/Create', [
                'locations' => $locations,
                'userLocation' => $userLocation
            ]);


        } else {
            return Redirect::route('noAccess');
        }

    }

    public function insertTransferHeader($assetTransferNo,$dateNow,$transferTo){

        AssetTransferHeader::insert([
            'ASSET_TRANSFER_NO' => $assetTransferNo,
            'TRANSACTION_DATE' => $dateNow,
            'TRANSFERED_LOCATION_ID' => $transferTo,
            'LOCATION_ID' => Auth::user()->LOCATION_ID,
            'TRANSFER_STATUS' => 'TO RECEIVE',
        ]);


    }


    public function insertTransferAssetDetails($assetTransferNo,$serialNumbers){


        foreach($serialNumbers as $serialNo){
            AssetTransferAssetDetail::insert([
                'ASSET_TRANSFER_NO' => $assetTransferNo,
                'SERIAL_NO' => $serialNo['number']
            ]);

            // Update the inventory status into FOR_TRANSFER
            Inventory::where('SERIAL_NO',$serialNo['number'])->update([
                'FOR_TRANSFER' => 1
            ]);

        }

    }

    public function store(HttpRequest $request)
    {
        // dd($request->all());
        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {

            // Get Date Today
                $dateNow = date('Y-m-d');
            // Transfer to location
                $transferTo = $request->transferTo;
            // Check if theres and asset transfer for current date
                $AssetTransferCount = AssetTransferHeader::where('TRANSACTION_DATE',$dateNow)->count();
            // Generate Asset Transfer No
                $assetTransferNo = 'ATFN-'.str_pad($AssetTransferCount + 1 , 8, '0', STR_PAD_LEFT);
            // Serial Numbers
            $serialNumbers = $request->serialNo;

            try {
                // Begin transaction
                DB::beginTransaction();

                $this->insertTransferHeader($assetTransferNo,$dateNow,$transferTo);
                $this->insertTransferAssetDetails($assetTransferNo,$serialNumbers);

                // Commit transaction
                DB::commit();

                return Redirect::route('Inventory.AssetTransfer.index')->with('success', 'Asset Transfer Transaction Created Successfully.');

            } catch (\Exception $e) {
                // Rollback transaction if an exception occurred
                DB::rollBack();
                // Log the error
                Log::error('Error occurred during database transaction: ' . $e->getMessage());

                return Redirect::back()->with('error', 'An Error Occur.');
            }

        } else {
            return Redirect::route('noAccess');
        }

    }



    public function show($assetTransNo)
    {

        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {

            $assetTransfer = AssetTransferHeader::where([
                'ASSET_TRANSFER_NO' => $assetTransNo,
                'LOCATION_ID' => Auth::user()->LOCATION_ID
            ])->with('assetTransferAssetDetails.inventory.product','location')->first();

            if (!$assetTransfer) {
                // No related assetTransferAssetDetails
                return Inertia::render('Errors/FindOrFail',[
                    'statusTitle' => "Could not be Found",
                    'paragraph' => "Asset Transfer Number Could not be found!"
                ]);

            } else {
                // Related assetTransferAssetDetails exist
                return Inertia::render('Inventory/AssetTransfer/Show', ['assetTransfer' => $assetTransfer]);
            }

        } else {
            return Redirect::route('noAccess');
        }

    }


}
