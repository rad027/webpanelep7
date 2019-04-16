<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'content',
    	'title'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
