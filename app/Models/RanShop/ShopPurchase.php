<?php

namespace App\Models\RanShop;

use Illuminate\Database\Eloquent\Model;

class ShopPurchase extends Model
{
    protected $connection = 'sqlsrv6';

    protected $table = "ShopPurchase";

    protected $primaryKey = 'PurKey';

    public $timestamps = false;

    protected $fillable = [
        'UserUID',
        'ProductNum'
    ];
}
