<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'content',
    	'remark',
    	'ip_address'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
