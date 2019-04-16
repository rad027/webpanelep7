<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KBCategory extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'title'
    ];

    public function knowledgebase()
    {
        return $this->hasMany('App\Models\knowledgeBase','category_id');
    }
}
