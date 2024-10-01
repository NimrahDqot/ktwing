<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventCompleteRequest extends Model
{
    use SoftDeletes;
    protected $table = 'event_complete_requests';
    protected $fillable = [
        'volunteer_id', 'event_id', 'village_id', 'event_detail', 'visitor_detail', 'uploaded_photos', 'uploaded_videos', 'uploaded_audios', 'status',
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


    public function getUploadedPhotosAttribute()
    {
        if (!empty($this->attributes['uploaded_photos'])) {
            // Split the uploaded_photos string into an array
            $photos = explode(',', $this->attributes['uploaded_photos']);
            // Return the full URLs for the first three images
            return array_map(function ($photo) {
                return url('uploads/event/photos/' . trim($photo));
            }, array_slice($photos, 0, 3));
        }

        return [];

    }

    public function getUploadedVideosAttribute()
    {
        if (!empty($this->attributes['uploaded_videos'])) {
            // Split the uploaded_videos string into an array
            $videos = explode(',', $this->attributes['uploaded_videos']);
            // Return the full URLs for the first three videos
            return array_map(function ($video) {
                return url('uploads/event/videos/' . trim($video));
            }, array_slice($videos, 0, 3));
        }

        // Return an empty array if no videos are set
        return [];
    }

    public function getUploadedAudiosAttribute()
    {
        if (!empty($this->attributes['uploaded_audios'])) {
            // Split the uploaded_audios string into an array
            $audios = explode(',', $this->attributes['uploaded_audios']);
            // Return the full URLs for the first three audios
            return array_map(function ($audio) {
                return url('uploads/event/audios/' . trim($audio));
            }, array_slice($audios, 0, 3));
        }

        // Return an empty array if no audios are set
        return [];
    }

    public function event_category_info(){
        return $this->belongsTo(EventCategory::class,'event_category_id','id');
    }
    public function village_info(){
        return $this->belongsTo(Village::class,'village_id','id');
    }
    public function attendee_info(){
        return $this->belongsTo(Attendees::class,'attendees_id','id');
    }




    public function getUploadedPhotos()
    {
        if (!empty($this->attributes['uploaded_photos'])) {
            // Split the uploaded_photos string into an array
            $photos = explode(',', $this->attributes['uploaded_photos']);
            // Return the full URLs for the first three photos
            return array_map(function ($photo) {
                return url('uploads/event/photos/' . trim($photo));
            }, $photos);
        }

        // Return an empty array if no videos are set
        return [];
    }
    public function getUploadedVidios()
    {
        if (!empty($this->attributes['uploaded_videos'])) {
            // Split the uploaded_videos string into an array
            $videos = explode(',', $this->attributes['uploaded_videos']);
            // Return the full URLs for the first three videos
            return array_map(function ($video) {
                return url('uploads/event/videos/' . trim($video));
            }, $videos);
        }

        // Return an empty array if no videos are set
        return [];
    }
    public function getUploadedAudios()
    {
        if (!empty($this->attributes['uploaded_audios'])) {
            // Split the uploaded_audios string into an array
            $audios = explode(',', $this->attributes['uploaded_audios']);
            // Return the full URLs for the first three audios
            return array_map(function ($audio) {
                return url('uploads/event/audios/' . trim($audio));
            }, $audios);
        }

        // Return an empty array if no videos are set
        return [];
    }
}
