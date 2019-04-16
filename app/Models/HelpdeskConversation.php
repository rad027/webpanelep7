<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpdeskConversation extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'user_id',
    	'type',
    	'message'
    ];

    public function helpdesk()
    {
        return $this->belongsTo('App\Models\Helpdesk');
    }
}
