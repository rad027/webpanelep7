<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteTopSite extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'title',
    	'image_link',
    	'link',
    	'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
