<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Helpdesk extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'title',
    	'category',
    	'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function HelpdeskConversation()
    {
        return $this->hasMany('App\Models\HelpdeskConversation');
    }   
}
