<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubModule extends Model
{

    protected $fillable = [
         'name', 'key', 'status', 'sort_by', 'module_id'
    ];

    public function Module(){
      return  $this->belongsTo(Module::class);
    }

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = strtoupper($value);
    }

    // Mutator for the 'name' attribute
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

}
