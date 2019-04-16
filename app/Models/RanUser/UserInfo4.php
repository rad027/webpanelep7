<?php

namespace App\Models\RanUser;

use Illuminate\Database\Eloquent\Model;
use jeremykenedy\LaravelRoles\Models\Role;

class UserInfo4 extends Model
{
    protected $connection = 'sqlsrv4';

    protected $table = "UserInfo";

    protected $primaryKey = 'UserNum';

    public $timestamps = false;

    protected $fillable = [
        'UserName',
        'UserID',
        'UserPass',
        'UserPass2',
        'UserEmail',
        'UserSQ',
        'UserSA',
        'UserAvailable',
        'ChaRemain'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function user_2()
    {
        return $this->hasMany('App\Models\User','name','UserName');
    } 

    public function roles(){
        return $this->hasMany('jeremykenedy\LaravelRoles\Models\Role','id');
    }

    public function ChaInfo3()
    {
        return $this->hasMany('App\Models\RanGame1\ChaInfo','UserNum');
    }  

    public function Char()
    {
        return $this->belongsTo('App\Models\RanGame1\ChaInfo','UserNum');
    }  
}
