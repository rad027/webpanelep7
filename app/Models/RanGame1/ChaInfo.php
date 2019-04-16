<?php

namespace App\Models\RanGame1;

use Illuminate\Database\Eloquent\Model;

class ChaInfo extends Model
{
    protected $connection = 'sqlsrv3';

    protected $table = "ChaInfo";

    protected $primaryKey = 'ChaNum';

    protected $fillable =   [
        'ChaClass',
        'ChaSkills',
        'ChaSkillslot',
        'ChaSkillPoint',
        'ChaPremiumPoint'
    ];

    public $incrementing = false;

    public $timestamps = false;

    /*protected $fillable = [
    	''
    ];*/

    public function UserInfo4()
    {
        return $this->belongsTo('App\Models\RanUser\UserInfo4');
    }

    public function info()
    {
        return $this->hasMany('App\Models\RanUser\UserInfo4','UserNum','UserNum');
    }

    public function GuildInfo()
    {
        return $this->hasMany('App\Models\RanGame1\GuildInfo','GuNum','GuNum');
    }  
}
