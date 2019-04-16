<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Downloads extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'content',
    	'title',
    	'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
