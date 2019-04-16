<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Authenticatable
{
    use HasRoleAndPermission;
    use Notifiable;
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'sqlsrv';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'activated',
        'token',
        'signup_ip_address',
        'signup_confirmation_ip_address',
        'signup_sm_ip_address',
        'admin_ip_address',
        'updated_ip_address',
        'deleted_ip_address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activated',
        'token',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * Build Social Relationships.
     *
     * @var array
     */
    public function social()
    {
        return $this->hasMany('App\Models\Social');
    }

    /**
     * User Profile Relationships.
     *
     * @var array
     */
    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    // User Profile Setup - SHould move these to a trait or interface...

    public function profiles()
    {
        return $this->belongsToMany('App\Models\Profile')->withTimestamps();
    }

    public function hasProfile($name)
    {
        foreach ($this->profiles as $profile) {
            if ($profile->name == $name) {
                return true;
            }
        }

        return false;
    }

    public function assignProfile($profile)
    {
        return $this->profiles()->attach($profile);
    }

    public function removeProfile($profile)
    {
        return $this->profiles()->detach($profile);
    }

    public function UserInfo4()
    {
        return $this->hasMany('App\Models\RanUser\UserInfo4','UserID','name');
    }   

    public function UserInfo4_2()
    {
        return $this->belongsTo('App\Models\RanUser\UserInfo4');
    }   

    public function Points()
    {
        return $this->hasMany('App\Models\Points');
    }  

    public function TopUp()
    {
        return $this->hasMany('App\Models\TopUp');
    }    

    public function VotePanel()
    {
        return $this->hasMany('App\Models\VotePanel');
    }   

    public function Timeline()
    {
        return $this->hasMany('App\Models\Timeline');
    }   

    public function Announcement()
    {
        return $this->hasMany('App\Models\Announcement');
    }   

    public function Downloads()
    {
        return $this->hasMany('App\Models\Downloads');
    }   

    public function Cart()
    {
        return $this->hasMany('App\Models\Cart');
    }  

    public function Helpdesk()
    {
        return $this->hasMany('App\Models\Helpdesk');
    }   

    public function VoteTopSite()
    {
        return $this->hasMany('App\Models\VoteTopSite');
    }   

    public function VoteLog()
    {
        return $this->hasMany('App\Models\VoteLog');
    }   

    public function AboutUs()
    {
        return $this->hasMany('App\Models\AboutUs');
    }   
}
