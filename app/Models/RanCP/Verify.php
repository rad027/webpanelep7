<?php

namespace App\Models\RanCP;

use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    protected $connection = 'sqlsrv2';

    protected $table = "Verify";

    public $timestamps = false;

    protected $fillable = [
        'UserName',
        'Email',
        'Code'
    ];
}
