<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteLog extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'vote_site_id',
    	'ip_address'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
