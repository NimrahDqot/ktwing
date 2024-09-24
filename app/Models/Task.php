<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'role_id', 'module_id', 'sub_module_id'
    ];

    public function Module(){
      return  $this->belongsToMany(Module::class);
    }
    public function SubModule(){
        return  $this->belongsToMany(SubModule::class);
      }
    public function Role(){
        return  $this->belongsTo(Role::class);
      }


}
