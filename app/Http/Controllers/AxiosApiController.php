<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class AxiosApiController extends Controller
{

       //=== DEFAULT TOKEN
    public $token = "w4SK5hO3uZvA6Fi3Bj4nfI36-7JRyf6FGqYFVtZcK03rrU5pRt-DuullFo5l2nlo6ZlvTb_a07wOAvpeWaoHzi";

    public function getInventoryItem(Request $request)
    {

         // Validate the incoming request
                $request->validate([
                        'userLocation' => 'required|integer',
                        'serialNo' => 'required|string'
                ]);


                $data = Inventory::with('product')->where([
                        'LOCATION_ID' => $request->userLocation,
                        'SERIAL_NO' => $request->serialNo,
                ])->first();



                // Check if the data is found
                if ($data) {

                        // Check if it reserved for transfer
                        if($data->FOR_TRANSFER == 1){
                                return response()->json(['message' => 'Could not select. Product already reserved for transfer.'], 404);
                        }

                        if($data->FOR_DISPOSAL == 1){
                                return response()->json(['message' => 'Could not select. Product already reserved for disposal.'], 404);
                        }

                        if($data->IS_DISPOSED == 1){
                                return response()->json(['message' => 'Could not select. Product already disposed.'], 404);
                        }

                        // If data is found and theres no problem, return the data
                        return response()->json($data);
                        
                } else {
                        // If no data is found, return a not found responsey
                        return response()->json(['message' => 'No inventory item found with the given serial number.'], 404); // Using HTTP status code 404 for not found
                }
    }

}
