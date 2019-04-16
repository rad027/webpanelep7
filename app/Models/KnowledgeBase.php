<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeBase extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'title',
    	'content',
    	'status'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\KBCategory','category_id','id');
    } 
}
