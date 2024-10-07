<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Volunteer;
use App\Models\AppLanguage;
use App\Models\Notification;
use App\Models\Visitor;
use App\Models\EventPhotoRequest;
use App\Models\EventVideoRequest;
use App\Models\EventAudioRequest;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Attendees;
use App\Models\Banner;
use App\Models\Event;
use App\Models\EventCompleteRequest;
use Validator;
use Hash;
use Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{



    public function login(Request $request) {
        // Validation logic
        $validator = Validator::make($request->only(['email_or_phone','token', 'referal_code','fcm_token','device_id','jwt_token','token']), [
            'email_or_phone' => 'required|string|max:25',
            'token' => 'required|string',
            // 'referal_code' => 'required|string',
            'fcm_token' => 'required|string',
            'device_id' => 'required|string',
            'jwt_token' => 'required|string',
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $credentials = $request->email_or_phone;
        $referal_code = $request->referal_code;
        $fcm_token = $request->fcm_token;
        $device_id = $request->device_id;
        $jwt_token = $request->jwt_token;
        $custom_user_token = $request->token;

        try {
            // Get user by email or phone
            $user = User::where('email', $credentials)
                ->orWhere('phone', $credentials)
                ->first();

            // Get refer ID if volunteer exists
            $refer_user = Volunteer::where('referal_code', $referal_code)->value('id');
            $refer_id = $refer_user ? $refer_user : 0;

            if ($user) {
                if ($user->status !== '1') {
                    return $this->sendError('User account is inactive.');
                }
                // Update user tokens
                $user->jwt_token = $jwt_token;
                $user->custom_user_token = $custom_user_token;
                $user->fcm_token = $request->fcm_token;
                $user->device_id = $request->device_id;
                $user->save();



                // Generate an access token
                $success = [
                    'token' => $user->createToken('MyApp')->plainTextToken,
                    'id' => $user->id,
                ];

                return $this->sendResponse($success, 'User logged in successfully.');
            } else {
                $user = new User();
                if (filter_var($credentials, FILTER_VALIDATE_EMAIL)) {
                    $user->email = $credentials;
                } elseif (preg_match('/^\d+$/', $credentials)) {
                    $user->phone = $credentials;
                } else {
                    return $this->sendError('Invalid email or phone format.');
                }
                // Set other user properties
                $user->refer_id = $refer_id;
                $user->fcm_token = $fcm_token;
                $user->device_id = $device_id;
                $user->jwt_token = $jwt_token;
                $user->custom_user_token = $custom_user_token;
                $user->save();

                return $this->sendResponse($user, 'User registered successfully.');
            }
        } catch (\Exception $e) {
            // Log the exception (you may want to implement logging)
            Log::error('Login error: ' . $e->getMessage());
            return $this->sendError('An error occurred. Please try again later.');
        }
    }

    public function profile(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id|max:25',
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            $user_id = $request->user_id;

            // $profile_detail = Volunteer::where('id', $user_id)->where('status', "1")->select('id','name','email','role_id','image','phone','experience')->first();
            $profile_detail = User::where('id', $user_id)->select('id', 'refer_id', 'name', 'phone', 'email', 'dob', 'gender', 'image', 'status')->first();
            return $this->sendResponse($profile_detail, 'Profile detail retrieved successfully.');

        } catch (\Exception $e) {
            return $this->sendError('An error occurred while retrieving app strings.', $e->getMessage());
        }
    }

    public function update_profile(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id|max:25',
            'name' => 'required|max:25',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => [
                'nullable',
                'min:10',
                'max:10',
                Rule::unique('users')->ignore($request->user_id),
            ],
            'email' => [
                'nullable',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                Rule::unique('users')->ignore($request->user_id), // Use the correct table
            ],

        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            $user_id = $request->user_id;
            $user = User::find($user_id);
            if (!$user) {
                return $this->sendError('User not found.');
            }
            if($request->hasFile('image')){
                @unlink(public_path('uploads/users/'.$user->image)); // Unlink old image
                $ext = $request->file('image')->extension();
                $rand_value = md5(mt_rand(11111111,99999999));
                $final_name = $rand_value.'.'.$ext;
                $request->file('image')->move(public_path('uploads/users/'), $final_name);

                $user['image'] = $final_name; // Update with new image name
            }
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->dob = $request->dob;
            $user->email = $request->email;
            $user->gender = $request->gender; //'Male', 'Female', 'Other
            $user->save();
            return $this->sendResponse($user, 'Profile detail retrieved successfully.');

        } catch (\Exception $e) {
            return $this->sendError('An error occurred while retrieving app strings.', $e->getMessage());
        }
    }
}
