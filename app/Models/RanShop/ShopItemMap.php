<?php

namespace App\Models\RanShop;

use Illuminate\Database\Eloquent\Model;

class ShopItemMap extends Model
{
    protected $connection = 'sqlsrv6';

    protected $table = "ShopItemMap";

    protected $primaryKey = 'ProductNum';

    public $timestamps = false;

    protected $fillable = [
        'ItemName',
        'ItemMain',
        'ItemSub',
        'ItemSec',
        'Itemstock',
        'ItemPrice',
        'ItemCtg',
        'ItemSS',
        'ItemComment',
        'IsHidden'
    ];

    public function Cart()
    {
        return $this->belongsTo('App\Models\Cart');
    }
}
