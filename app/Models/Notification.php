<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'title',
        'description',
        'type',
        'status'
    ];
public function volunteer_details(){
    return self::belongsTo(Volunteer::class,'user_id','id');

}
}
