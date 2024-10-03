<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    protected $fillable = [
        'username', 'dob', 'email', 'mobile', 'password', 'image', 'usertype', 'activation_status', 'is_admin'

    ];
}
