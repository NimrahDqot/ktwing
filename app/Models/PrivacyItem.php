<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyItem extends Model
{
    protected $fillable = [
        'name',
        'detail',
        'status'
    ];

}
