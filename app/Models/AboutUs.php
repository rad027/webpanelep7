<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = "about_uses";

    protected $fillable = [
    	'content',
    	'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
