<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $connection = 'sqlsrv';

    protected $fillable = [
    	'product_id',
    	'quantity'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function Product()
    {
        return $this->hasMany('App\Models\RanShop\ShopItemMap','ProductNum','product_id');
    }   
}
