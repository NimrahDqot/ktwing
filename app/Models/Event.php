<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    protected $fillable = [
         'name', 'description', 'image', 'village_id', 'event_category_id', 'event_date', 'event_time', 'event_duration', 'event_agenda', 'expected_attendance', 'resoure_list', 'status', 'event_status','attendees_id'
    ];


    public function getImageAttribute() {
        // If the image attribute exists in the database, return its full path
        if (!empty($this->attributes['image'])) {
            return url('uploads/event/' . $this->attributes['image']);
        }

        // Return the default image path if no image is set
        $defaultImage = url('uploads/default/default.jpg');
        return $defaultImage;
    }

      public function event_category_info(){
        return $this->belongsTo(EventCategory::class,'event_category_id','id');
    }
}
