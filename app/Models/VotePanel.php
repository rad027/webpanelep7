<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotePanel extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'vote_link',
    	'ip_address'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
