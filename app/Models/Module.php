<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
         'name', 'key', 'status', 'sort_by'
    ];

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = strtoupper($value);
    }

    // Mutator for the 'name' attribute
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }
    public function subModules()
    {
        return $this->hasMany(SubModule::class);
    }
}

