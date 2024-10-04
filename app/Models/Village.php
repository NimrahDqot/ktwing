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

    public function events()
    {
        return $this->hasMany(Event::class)->select('village_id'); // Assuming your event model uses a foreign key village_id
    }

    public function scopeActive($query){
        return $query->where('status',1);
    }
}
