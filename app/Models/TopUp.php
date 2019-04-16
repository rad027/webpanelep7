<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'code',
    	'pin_code',
    	'status',
    	'amount',
        'function'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
