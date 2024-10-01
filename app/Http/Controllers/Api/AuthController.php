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
            $per_page = isset($request->per_page) ? (int)$request->per_page : 10;
            $user_id = $request->user_id;
            // Fetch language data
            $language_data = Notification::where('user_id',$user_id)->select('id','user_id','title','description','created_at','type')->orderBy('created_at', 'asc')->paginate($per_page);
            $response = [
                'current_page' => $language_data->currentPage(),
                'next_page' => $language_data->hasMorePages() ? $language_data->currentPage() + 1 : null,
                'total_pages' => $language_data->lastPage(),
                'data' => $language_data->items(),
            ];  // Return success response
            return $this->sendResponse($response, 'Notification list retrieved successfully.');
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

            // $profile_detail = Volunteer::where('id', $user_id)->where('status', "1")->select('id','name','email','role_id','image','phone','experience')->first();
            $profile_detail = Volunteer::where('id', $user_id)->select('id','village_id','password','name','email','role_id','image','phone','experience')->first();

            // Check if a profile was found
            // if (!$profile_detail) {
            //     return $this->sendError('No active profile found for this user.');
            // }
            $profile_detail['role_name'] = isset($profile_detail->Role->name) ? $profile_detail->Role->name : 'Volunteer';
            $profile_detail['village_count'] = $profile_detail['village_count'];

            $events = $this->getEventsByUserId($user_id);
            $total_events = $this->getTotalEventsByUserId($user_id);
            $profile_detail['event_count'] = $total_events;
            $profile_detail['events'] = $events;

            return $this->sendResponse($profile_detail, 'Profile detail retrieved successfully.');

        } catch (\Exception $e) {
            return $this->sendError('An error occurred while retrieving app strings.', $e->getMessage());
        }
    }
    public function getEventsByUserId($user_id)
    {
        // Fetch events that match the user_id
        $events = Event::whereRaw("FIND_IN_SET(?, volunteer_id)", [$user_id])
            ->select('event_status', 'image','name','village_id') // Select the required fields
            ->get();

        // Group by event status and count
        $eventsCount = $events->groupBy('event_status')->map(function ($group) {
            return [
                'event_status' => $group->first()->event_status,
                'count' => $group->count(),
                'image' => $group->first()->image,
                'name' => $group->first()->name,
                'village' => $group->first()->village_info->name
            ];
        })->values(); // Get the final collection

        return $eventsCount;
    }

    public function getTotalEventsByUserId($user_id)
    {
        // Fetch events that match the user_id
        $eventsCount = Event::whereRaw("FIND_IN_SET(?, volunteer_id)", [$user_id])
            ->count();


        return $eventsCount;
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

    public function all_events(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:volunteers,id|max:25',
            'type' => 'required|in:Completed,Ongoing,Upcoming',
        ]);
        // Return validation errors if validation fails
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        try{
            $user_id = $request->user_id;
            $type = $request->type;
            $per_page = isset($request->per_page) ? (int)$request->per_page : 10;
            $page_no = isset($request->page_no) ? (int)$request->page_no : 1; // Default to page 1 if not set


            $events = Event::whereRaw("FIND_IN_SET(?, volunteer_id)", [$user_id])
            ->where('event_status',$type)
            ->with('village_info:name,id')
            ->select('id','event_status', 'image','name','village_id','event_date','event_time') // Select the required fields
            ->paginate($per_page,['*'], 'page', $page_no);

            $response = [
                'current_page' => $events->currentPage(),
                'next_page' => $events->hasMorePages() ? $events->currentPage() + 1 : $events->lastPage(),
                'total_pages' => $events->lastPage(),
                'data' => $events->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'event_status' => $event->event_status,
                        'image' => $event->image,
                        'name' => $event->name,
                        'village' => isset($event->village_info->name) ? $event->village_info->name : 'N/A', // Directly access village name with null fallback
                        'event_date' => $event->event_date,
                        'event_time' => $event->event_time,
                    ];
                })->toArray(),
            ];
            return $this->sendResponse($response, 'Events Retrieve successfully.');
        }catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->sendError('An error occurred while retrieving app strings.', $e->getMessage());
        }
    }

    public function event_detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:volunteers,id|max:25',
            'event_id' => 'required|exists:events,id|max:25',
        ]);
        // Return validation errors if validation fails
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        try{
            $user_id = $request->user_id;
            $event_id = $request->event_id;
            $event = Event::whereRaw("FIND_IN_SET(?, volunteer_id)", [$user_id])
            ->where('id',$event_id)
            ->with('village_info:id,name') // Eager load village name
            ->with('attendee_info:id,name,role,image') // Eager load village name
            ->select('id','event_status', 'image','name','village_id','event_date','event_time','description','event_duration','event_agenda','attendees_id','expected_attendance','volunteer_id','event_status','uploaded_photos','uploaded_videos','uploaded_audios') // Select the required fields
            ->first();

            if (!$event) {
                return $this->sendError('Event not found.');
            }
            $attendeeIds = explode(',', $event->attendees_id);

            $attendees = Attendees::whereIn('id', $attendeeIds)
                ->select('id', 'name', 'role', 'image')
                ->get();
                // Process uploaded photos, videos, and audios


            $response = [
                'id' => $event->id,
                'event_status' => $event->event_status,
                'image' => $event->image,
                'name' => $event->name,
                'expected_attendance' => $event->expected_attendance,
                'village' => $event->village_info->name ?? 'N/A',
                'event_date' => $event->event_date,
                'event_time' => $event->event_time,
                'description' => $event->description,
                'event_duration' => $event->event_duration,
                'event_agenda' => $event->event_agenda,
                'uploaded_photos' =>$event->uploaded_photos,
                'uploaded_videos' =>$event->uploaded_videos,
                'uploaded_audios' =>$event->uploaded_audios,
                'attendees' => $attendees,
            ];


            return $this->sendResponse($response, 'Events Retrieve successfully.');
        }catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->sendError('An error occurred while retrieving app strings.', $e->getMessage());
        }
    }

    public function create_event_request(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:volunteers,id|max:25',
            'event_id' => 'required|exists:events,id|max:25',
            'uploaded_photos' => 'required|array',
            // 'uploaded_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'uploaded_videos' => 'required|array',
            'uploaded_audios' => 'required|array',
        ]);
        // Return validation errors if validation fails
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        try{
            $user_id = $request->user_id;
            $event_id = $request->event_id;

            $eventRequest = Event::find($event_id);

            if (!$eventRequest) {
                return $this->sendError('Event id not found.');
            }

            if ($request->hasFile('uploaded_photos')) {
                foreach ($request->file('uploaded_photos') as $photo) {
                    $photoName = md5(mt_rand(11111111, 99999999)) . '.' . $photo->extension();
                    $photo->move(public_path('uploads/event/photos'), $photoName);

                    // Create a new photo request record
                    EventPhotoRequest::create([
                        'event_id' => $event_id,
                        'volunteer_id' => $user_id,
                        'uploaded_photos' => $photoName,
                    ]);
                }
            }


            if ($request->hasFile('uploaded_videos')) {
                foreach ($request->file('uploaded_videos') as $video) {
                    $videoName = md5(mt_rand(11111111, 99999999)) . '.' . $video->extension();
                    $video->move(public_path('uploads/event/videos'), $videoName);

                    // Create a new video request record
                    EventVideoRequest::create([
                        'event_id' => $event_id,
                        'volunteer_id' => $user_id,
                        'uploaded_videos' => $videoName,
                    ]);
                }
            }


           // Handle multiple uploaded audios
        if ($request->hasFile('uploaded_audios')) {
            foreach ($request->file('uploaded_audios') as $audio) {
                $audioName = md5(mt_rand(11111111, 99999999)) . '.' . $audio->extension();
                $audio->move(public_path('uploads/event/audios'), $audioName);

                // Create a new audio request record
                EventAudioRequest::create([
                   'event_id' => $event_id,
                    'volunteer_id' => $user_id,
                    'uploaded_audios' => $audioName,
                ]);
            }
        }

                return $this->sendResponse($eventRequest, 'Event request created successfully.');

        }catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->sendError('An error occurred while retrieving app strings.', $e->getMessage());
        }
    }

    public function event_medias(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:volunteers,id|max:25',
            'event_id' => 'required|exists:events,id|max:25',
            'type' => 'required|in:Photo,Video,Audio',
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        try {
            $user_id = $request->user_id;
            $event_id = $request->event_id;
            $type = $request->type;

            $event = Event::find($event_id);


            if (!$event) {
                return $this->sendError('Event id not found.');
            }

            $event = Event::whereRaw("FIND_IN_SET(?, volunteer_id)", [$user_id])
            ->where('id',$event_id)
            ->with('village_info:id,name') // Eager load village name
            ->select('id','name','village_id','event_date','expected_attendance','uploaded_photos','uploaded_videos','uploaded_audios') // Select the required fields
            ->first();
            $response = [
                'id' => $event->id,
                'name' => $event->name,
                'expected_attendance' => $event->expected_attendance,
                'village' => $event->village_info->name ?? 'N/A',
                'event_date' => $event->event_date,

            ];
            $media = match ($type) {
                'Photo' => [
                    'uploaded_photos' => $event->getUploadedPhotos(), // Calls the accessor
                    'uploaded_videos' => [],
                    'uploaded_audios' => []
                ],
                'Video' => [
                    'uploaded_photos' => [],
                    'uploaded_videos' => $event->getUploadedVidios(), // Calls the accessor
                    'uploaded_audios' => []
                ],
                'Audio' => [
                    'uploaded_photos' => [],
                    'uploaded_videos' => [],
                    'uploaded_audios' => $event->getUploadedAudios() // Calls the accessor
                ],
            };
            return $this->sendResponse(array_merge($response, $media), 'Event Media Retrieved successfully.');
            // return $this->sendResponse($response, 'Event Media Retrieve successfully.');

        } catch (\Exception $e) {
            // Handle exceptions and return error response
            return $this->sendError('An error occurred while creating the event request.', $e->getMessage());
        }
    }
}
