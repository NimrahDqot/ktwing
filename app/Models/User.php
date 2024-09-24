<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    protected $fillable = [
     'username', 'dob', 'email', 'mobile', 'password', 'image', 'usertype', 'activation_status', 'is_admin'
    ];

    public function Role(){
        return   $this->belongsTo(Role::class,'usertype');
       }
}
