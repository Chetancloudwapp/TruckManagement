<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FcmToken;
use App\Models\User;
use Validator;
use Auth;
use Hash;
use DB;

class AuthController extends Controller
{
    /* --- function for casting--- */
    function allString($object)
    {
        // Get the object's attributes
        $attributes = $object->getAttributes();

        // Iterate through the attributes and apply conversions
        foreach ($attributes as $key => &$value) {
            if (is_null($value)) {
                $value = "";
            } elseif (is_numeric($value) && !is_float($value)) {
                // Convert numeric values to integers (excluding floats)
                $value = (string) $value;
            }
            // Add more conditions for other types if needed
        }

        // Set the modified attributes back to the object
        $object->setRawAttributes($attributes);
        return $object;
    }

    /* --- Login Api --- */
    public function UserLogin(Request $request)
    {
        $header = $request->header('CLIENT');
        if(empty($header)){
            $message = "Authorization token is required.";
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $message,
            ],422);
        }else{
            if($header == "Bearer JzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkMkJSEyXiopIiw"){
                $userData = $request->all();

                $rules = [
                    'email'       => 'required|email',
                    'password'    => 'required|min:6',
                    "fcm_token"   => "required",
                    "device_type" => "required|in:android,ios",
                    "device_id"   => "required",
                ];

                $validator = Validator::make($userData, $rules);
                if($validator->fails()){
                    return response()->json([
                        'status'  => false,
                        'message' => $validator->errors()->first(),
                    ],422);
                }

                // if(Auth::attempt(['email' => $userData['email'], 'password' => $userData['password']])){


                // }else{
                //     return response()->json([

                //     ])
                // }
            }else{
                $message = "Authorization token is Incorrect!";
                return response()->json([
                    'status'      => false,
                    'status_code' => 422,
                    'message'     => $message,
                ],422);
            }
        }
    }

    /* --- Profile Update Api --- */
    public function DriverProfileUpdate(Request $request)
    {
        try{
            $rules = [
                "first_name"   => "required|string|regex:/^[^\d]+$/|min:2|max:255",
                "last_name"    => "required|string|regex:/^[^\d]+$/|min:2|max:255",
                "phone_number" => "numeric|digits_between:9,15",
                "image"        => "mimes:jpeg,jpg,png",
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(), 
                ],422);
            }

            $user = auth()->user();
            if(isset($request->image)){
                if($request->has('image')){
                    $image = $request->file('image');
                    $name = time(). "." .$image->getClientOriginalExtension();
                    $path = public_path('uploads/drivers/');
                    $image->move($path, $name);
                    $user->image = $name;
                }
            }

            // Update the validated data
            $user->update($validator->validated());

            $user['image'] = $user['image'] !='' ? asset('uploads/drivers/'.$user['image']) : asset('uploads/placeholder/default_user.png');

            /* --- Typecast the data --- */
            $user = $this->allString($user);
            $message = "Profile Updated Successfully!";
            return response()->json([
                'status'      => true,
                'status_code' => 200,
                'message'     => $message,
                'data'        => $user,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- Profile Detail Api --- */
    public function ProfileDetail(Request $request)
    {
        try{
            $user = auth()->user();
            $user['image'] = $user['image'] !='' ? asset('uploads/drivers/'.$user['image']) : asset('uploads/placeholder/default_user.png');
        
            /* --- Typecast the data --- */
            $user = $this->allString($user);
            $message = "Profile Detail Retrieve Successfully!";
            return response()->json([
                'status'     => true,
                'status_code' => 200,
                'message'     => $message,
                'data'        => $user,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $e->getMessage(),
            ],422);
        }
    }

    /* --- Logout Api --- */
    public function Logout(Request $request)
    {
        try{
            $user = auth()->user();
            $user->tokens()->delete();
            return response()->json(['status'=> true,'status_code'=>200,'message'=>'Driver Logout Successfully!'],200);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'status_code'=>422,'message'=> $e->getMessage()],422);
        }
    }
}


