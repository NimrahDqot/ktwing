<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppLanguage extends Model
{
    protected $table = 'app_panel_texts';
    protected $fillable = [
        'lang_key',	'lang_value'
    ];



}
