<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Volunteer;
use App\Models\AppLanguage;
use App\Models\Notification;
use App\Models\Visitor;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Banner;
use Validator;
use Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends BaseController
{

    public function login(Request $request) {
        // Validation logic
        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|string|max:25',
            'password' => 'required|string',
        ], [
            'password.required' => ERR_PASSWORD_REQUIRED
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        // Define the rate limit key, based on the IP address
        $rateLimitKey = 'login_attempt:' . $request->ip();

        // Check if the user has exceeded the login attempt limit (3 attempts in 1 minute)
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return $this->sendError('Too many login attempts. Please try again in ' . ceil($seconds / 60) . ' minutes.');
        }

        // Get credentials
        $credentials = $request->only('email', 'password');

        // Find the volunteer by email
        $volunteer = Volunteer::where('email', $credentials['email'])->first();

        // Check if the volunteer exists and if the password is correct
        if ($volunteer && Hash::check($credentials['password'], $volunteer->password)) {
            // Clear the rate limit on successful login
            RateLimiter::clear($rateLimitKey);

            // Check if the volunteer account is active
            if ($volunteer->status !== '1') {
                return $this->sendError('Volunteer account is inactive.');
            }

            // Generate an access token
            $success = [
                'token' => $volunteer->createToken('MyApp')->plainTextToken,
                'id' => $volunteer->id,
                'name' => $volunteer->name, // or any other field you'd like to return
            ];

            return $this->sendResponse($success, 'Volunteer logged in successfully.');
        } else {
            // Increment rate limit attempt count on failed login
            RateLimiter::hit($rateLimitKey, 60); // 60 seconds lockout for each failed attempt

            return $this->sendError('Invalid credentials.');
        }
    }


    public function app_string() {
        try {
            // Fetch language data
            // $language_data = AppLanguage::select('lang_key','lang_value')->orderBy('id', 'asc')->get();
            $language_data = AppLanguage::pluck('lang_value', 'lang_key')->toArray();
            // Return success response
            return $this->sendResponse($language_data, 'App string retrieved successfully.');
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->sendError('An error occurred while retrieving app strings.', $e->getMessage());
        }
    }


    public function banner() {
        try {
            // Fetch language data
            $language_data = Banner::select('title','image','type')->orderBy('sort_by', 'asc')->get();
            // Return success response
            return $this->sendResponse($language_data, 'App string retrieved successfully.');
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->sendError('An error occurred while retrieving app strings.', $e->getMessage());
        }
    }

    public function notification(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:volunteers,id|max:25',
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        try {
            $user_id = $request->user_id;
            // Fetch language data
            $language_data = Notification::where('id',$user_id)->select('id','user_id','title','description','created_at','type')->orderBy('created_at', 'asc')->get();
            // Return success response
            return $this->sendResponse($language_data, 'Notification list retrieved successfully.');
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->sendError('An error occurred while retrieving app strings.', $e->getMessage());
        }
    }

    public function profile(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:volunteers,id|max:25',
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        try {
            $user_id = $request->user_id;
            // Fetch language data
            // $profile_detail = Volunteer::where('id', $user_id)->where('status', "1")->select('id','name','email','role_id','image','phone','experience')->first();
            $profile_detail = Volunteer::where('id', $user_id)->select('id','village_id','name','email','role_id','image','phone','experience')->first();

            // Check if a profile was found
            // if (!$profile_detail) {
            //     return $this->sendError('No active profile found for this user.');
            // }
            $profile_detail['role_name'] = isset($profile_detail->Role->name) ? $profile_detail->Role->name : 'volunteer';
            $profile_detail['village_count'] = $profile_detail['village_count'];
            // Return success response
            return $this->sendResponse($profile_detail, 'Profile detail retrieved successfully.');
        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->sendError('An error occurred while retrieving app strings.', $e->getMessage());
        }
    }

    public function store_visitor(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:25',
            'phone' => 'required|min:10|max:10',
            'dob' => 'required|date',
            'role' => 'required|max:255',
            'bio' => 'required|max:255',
            'grade' => 'required|in:A,B,C,D',
            'review' => 'required',
            'audio' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional image validation
        ]);
        // Return validation errors if validation fails
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
    try{
        $visitor = new Visitor();
        $data = $request->only($visitor->getFillable());
        if($request->hasFile('image')){

            $rand_value = md5(mt_rand(11111111,99999999));
            $ext = $request->file('image')->extension();
            $final_name = $rand_value.'.'.$ext;
            $request->file('image')->move(public_path('uploads/visitor/'), $final_name);
            unset($data['image']);
            $data['image'] = $final_name;
        }

        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $audioName = time() . '.' . $audio->getClientOriginalExtension();
            $audio->move(public_path('uploads/visitor'), $audioName);
            $data['audio'] = $audioName;
        }
        $visitor->fill($data)->save();
        return $this->sendResponse($visitor, 'Visitor created successfully successfully.');
    }catch (\Exception $e) {
        // Handle exceptions and return error response
        return $this->sendError('An error occurred while retrieving app strings.', $e->getMessage());
    }
    }
}
