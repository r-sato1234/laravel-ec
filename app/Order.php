<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_UNCONFIRMED = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_CANCELLED = 3;
    const STATUSES = [
        self::STATUS_UNCONFIRMED => '未確認',
        self::STATUS_CONFIRMED => '注文確定',
        self::STATUS_CANCELLED => 'キャンセル'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * 注文製品を取得
     */
    public function orderItems()
    {
        return $this
            ->hasMany('App\OrderItem')
            ->select(DB::raw('price, item_id, count(*) as item_count, sum(price) as sub_total_price'))
            ->groupBy('item_id', 'price');
    }

    /**
     * 注文者を取得
     */
    public function user()
    {
        return $this
            ->belongsTo('App\User')
            ->select('name');
    }
}
