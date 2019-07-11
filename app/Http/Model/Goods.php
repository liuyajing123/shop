<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = "shop_goods";
    protected $primarKey = 'goods_id';

    public $timestamps = false;

    protected $connection = "mysql_shop";
}
