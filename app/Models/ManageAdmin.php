<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManageAdmin extends Model
{
    protected $table = 'admins';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'address',
        'state',
        'city',
        'zip',
        'website',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'pinterest',
        'youtube',
        'photo',
        'banner',
        'password',
        'token',
        'status',
        'user_name',
        'role_id'
    ];
    public function Role(){
     return   $this->belongsTo(Role::class);
    }
}
