<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleSubmoduleRole extends Model
{

    protected $fillable = [
       'task_id', 'module_id',	'sub_module_id',	'role_id'
    ];



}
