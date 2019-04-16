<?php

namespace App\Models\RanGame1;

use Illuminate\Database\Eloquent\Model;

class GuildInfo extends Model
{
    protected $connection = 'sqlsrv3';

    protected $table = "GuildInfo";

    protected $primaryKey = 'GuNum';

    public $incrementing = false;

    public $timestamps = false;

    /*protected $fillable = [
    	''
    ];*/

    public function ChaInfo()
    {
        return $this->belongsTo('App\Models\RanGame1\ChaInfo');
    }
}
