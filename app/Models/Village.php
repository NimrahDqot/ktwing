<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = [
        'name',
        'district',
        'population',
        'language',
        'contact',
        'status',
    ];

}
