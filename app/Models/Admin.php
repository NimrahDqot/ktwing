<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use SoftDeletes;
    protected $fillable = [
        'username', 'dob', 'email', 'mobile', 'password', 'image', 'role_id', 'activation_status', 'is_admin'
    ];


    public function getImageAttribute() {
        // If the image attribute exists in the database, return its full path
        if (!empty($this->attributes['image'])) {
            return url('uploads/admin_photos/' . $this->attributes['image']);
        }
        // Return the default image path if no image is set
        $defaultImage = url('uploads/default/default.jpg');
        return $defaultImage;
    }

    public function Role(){
        return   $this->belongsTo(Role::class,'role_id');
    }
}
