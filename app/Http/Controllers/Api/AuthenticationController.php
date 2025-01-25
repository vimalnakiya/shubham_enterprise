<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends BaseController
{
    public function store(Request $request)
    {   
       if (Auth::attempt(['email' => $request['email'],'password' => $request['password'],'status' => '1'])) {
            DB::table('oauth_access_tokens')->where('user_id',Auth::user()->id)->delete();
            $user = User::find(Auth::user()->id);
            $user->accessToken = $user->createToken('appToken');
            
            // if(isset($request['fcm_token'])){
            //     $device = $this->add_device($user->id,$request['fcm_token']);
            // }
            return $this->sendResponse(
                __('messages.loggedIn'),
                new UserResource($user)
            );
        } else {
            return $this->sendError(
                'Invalid Email Or Password Or User Not Verified',
                ['error' => __('Invalid Email Or Password Or User Not Verified')],
                200
            );
        }  
    }

    function signup(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorKeys = $errors->keys();
            $firstErrorKey = $errorKeys[0];
            $status = 0;
            if ($firstErrorKey == 'email') {
                $status = false;
            }
            return response()->json(
                [
                    'status' => $status,
                    'message' => $validator->errors()->first()
                ],
            );
        }
        
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->shopname = $request->shopname;
        $user->address = $request->address;
        $user->mobile = $request->mobile;
        // $user->assignRole('User');
        $user->role_id = 2;
        $user->save();
        $user->accessToken = $user->createToken('appToken');
        return $this->sendResponse(__('messages.registered'),new UserResource($user));
    }

    function check_email(Request $request){
        $email = $request->email;
        $exists = User::where('email', $email)->exists();
        return response()->json(!$exists);
    }
}
