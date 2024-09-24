<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermItem extends Model
{
    protected $fillable = [
        'name',
        'detail',
        'status',
    ];

}
