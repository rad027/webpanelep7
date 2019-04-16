<?php

namespace App\Models\RanCP;

use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = "Points";

    public $timestamps = false;

    protected $fillable = [
        'UserName',
        'UserPass',
        'Points',
        'VPoints'
    ];
}
