<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelReward extends Model
{
    protected $fillable = [
        'level_name', 'min_points', 'max_points', 'awards_amount', 'awads_gifts', 'awads_gifts_img', 'status', 'user_count'
    ];


}
