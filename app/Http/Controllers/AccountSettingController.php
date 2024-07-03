<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as HttpRequest;

class AccountSettingController extends Controller
{
    public function index(){


        return Inertia::render('AccountSetting/Index',[
            'userData' => Auth::user(),
        ]);
    }


    public function show(){

        return Inertia::render('AccountSetting/Show',[
            'userData' => Auth::user(),
        ]);
    }


    public function update(HttpRequest $request)
    {

        if($request->hasFile('new_profilePicture')){

            $file = $request->file('new_profilePicture');

            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            // Check Extension

            if($extension != 'png' && $extension != 'jpeg' && $extension != 'jpg'){
                return Redirect::back()->with('error', 'Image must be in png, jpeg or jpg format only.');
            }

             // Check if the file size is more than 5MB
             $maxSize = 5 * 1024 * 1024; // 5MB in bytes

             if ($size > $maxSize) {
                 // Handle the case where the file is larger than 5MB
                 return Redirect::back()->with('error', 'The file size exceeds the maximum limit of 5MB.');
             }

            $fileName = Auth::user()->USER_ID. date('YmdHis') . '.' . $extension;

            $file->move(public_path('images/userPhotos'), $fileName);

            $profile = $fileName;

             // Then Delete the old photo
                if($request->profilePicture != null){

                    $oldFileName = public_path('images/userPhotos') . '/' . $request->profilePicture;
                    if (file_exists($oldFileName)) {
                        unlink($oldFileName);
                    }

                }



         }else{

            $profile = $request->profilePicture;

         }

        User::where('USER_ID',Auth::user()->USER_ID)->update([
            'FIRST_NAME' => $request->firstName,
            'LAST_NAME' => $request->lastName,
            'PROFILE_PICTURE' => $profile,
        ]);


        return Redirect::route('AccountSetting.index')->with('success', 'Update Successfull.');
    }



}
