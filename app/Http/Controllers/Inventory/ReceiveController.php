<?php

namespace App\Http\Controllers\Inventory;

use Inertia\Inertia;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use App\Models\AssetTransferHeader;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AssetTransferAssetDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class ReceiveController extends Controller
{



    public function index()
    {

        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {

            $search = Request::input('search');
            $receive = AssetTransferHeader::select(
                'ASSET_TRANSFER_NO',
                'TRANSACTION_DATE',
                'TRANSFERED_LOCATION_ID',
                'LOCATION_ID',
                'DATE_RECEIVED',
                'TRANSFER_STATUS'
            )
            ->where([
                'TRANSFERED_LOCATION_ID' => Auth::user()->LOCATION_ID,
                'TRANSFER_STATUS' => 'TO RECEIVE'
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

            return Inertia::render('Inventory/Receive/Index', [
                'receive' => $receive,
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
            $receive = AssetTransferHeader::select(
                'ASSET_TRANSFER_NO',
                'TRANSACTION_DATE',
                'TRANSFERED_LOCATION_ID',
                'LOCATION_ID',
                'DATE_RECEIVED',
                'TRANSFER_STATUS'
            )
            ->where([
                'TRANSFERED_LOCATION_ID' => Auth::user()->LOCATION_ID
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

            return Inertia::render('Inventory/Receive/History', [
                'receive' => $receive,
                'filters' => Request::only(['search']),
            ]);

        } else {
            return Redirect::route('noAccess');
        }


    }

    public function historyShow($assetTransNo)
    {

        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {

            $assetTransfer = AssetTransferHeader::where([
                'ASSET_TRANSFER_NO' => $assetTransNo,
                'TRANSFERED_LOCATION_ID' => Auth::user()->LOCATION_ID
            ])->with('assetTransferAssetDetails.inventory.product','location')->first();

            if (!$assetTransfer) {
                // No related assetTransferAssetDetails
                return Inertia::render('Errors/FindOrFail',[
                    'statusTitle' => "Could not be Found",
                    'paragraph' => "Asset Transfer Number Could not be found!"
                ]);

            } else {
                // Related assetTransferAssetDetails exist
                return Inertia::render('Inventory/Receive/HistoryShow', ['assetTransfer' => $assetTransfer]);
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
                'TRANSFERED_LOCATION_ID' => Auth::user()->LOCATION_ID,
                'TRANSFER_STATUS' => 'TO RECEIVE',
            ])->with('assetTransferAssetDetails.inventory.product','location')->first();

            if (!$assetTransfer) {
                // No related assetTransferAssetDetails
                return Inertia::render('Errors/FindOrFail',[
                    'statusTitle' => "Could not be Found",
                    'paragraph' => "Asset Transfer Number Could not be found!"
                ]);

            } else {
                // Related assetTransferAssetDetails exist
                return Inertia::render('Inventory/Receive/Show', ['assetTransfer' => $assetTransfer]);
            }

        } else {
            return Redirect::route('noAccess');
        }

    }

    public function accept($assetTransNo)
    {


        if (Gate::allows('AuthorizeAction', ['INVENTORY'])) {

            $assetTransfer = AssetTransferHeader::where([
                'ASSET_TRANSFER_NO' => $assetTransNo,
                'TRANSFERED_LOCATION_ID' => Auth::user()->LOCATION_ID,
                'TRANSFER_STATUS' => 'TO RECEIVE',
            ])->with('assetTransferAssetDetails.inventory.product','location')->first();

            if (!$assetTransfer) {
                // No related assetTransferAssetDetails
                return Inertia::render('Errors/FindOrFail',[
                    'statusTitle' => "Could not be Found",
                    'paragraph' => "Asset Transfer Number Could not be found!"
                ]);

            } else {

                try {
                    // Begin transaction
                    DB::beginTransaction();

                     // Related assetTransferAssetDetails exist
                        AssetTransferHeader::where([
                            'ASSET_TRANSFER_NO' => $assetTransNo,
                            'TRANSFERED_LOCATION_ID' => Auth::user()->LOCATION_ID
                        ])->update(['TRANSFER_STATUS' => 'RECEIVED']);

                        // Get Serial Numbers of Asset Transfer
                        $serialNumbers = AssetTransferAssetDetail::where('ASSET_TRANSFER_NO',$assetTransNo)->pluck('SERIAL_NO')->toArray();
                        // Update Inventory Status
                        Inventory::where('FOR_TRANSFER',1)
                        ->whereIn('SERIAL_NO',$serialNumbers)
                        ->update(['FOR_TRANSFER' => 0, 'LOCATION_ID' => Auth::user()->LOCATION_ID]);

                        DB::commit();

                        return Redirect::route('Inventory.Receive.index')->with('succes','Asset Transfer Received Successfully');
                    // Commit transaction

                } catch (\Exception $e) {
                    // Rollback transaction if an exception occurred
                    DB::rollBack();

                    // Log the error
                    Log::error('Error occurred during database transaction: ' . $e->getMessage());

                    return Redirect::back()->with('error', 'An Error Occur.');
                }


            }

        } else {
            return Redirect::route('noAccess');
        }

    }

    public function reject($assetTransNo)
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
