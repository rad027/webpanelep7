<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'points',
    	'Vpoints'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
