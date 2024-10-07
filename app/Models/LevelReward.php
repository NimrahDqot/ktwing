<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LevelReward extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'level_name', 'min_points', 'max_points', 'awards_amount', 'awads_gifts', 'image', 'status', 'min_users_for_level'
    ];
    public function getImageAttribute() {
        // If the image attribute exists in the database, return its full path
        if (!empty($this->attributes['image'])) {
            return url('uploads/level_rewards/' . $this->attributes['image']);
        }

        // Return the default image path if no image is set
        $defaultImage = url('uploads/default/gift.avif');
        return $defaultImage;
    }

}
