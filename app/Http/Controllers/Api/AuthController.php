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


}
