<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const STATUS_UNCONFIRMED = 1; // 未確認
    const STATUS_CONFIRMED = 2; // 注文確定
    const STATUS_CANCELLED = 3; // キャンセル
    const STATUSES = [
        self::STATUS_UNCONFIRMED => '未確認',
        self::STATUS_CONFIRMED => '注文確定',
        self::STATUS_CANCELLED => 'キャンセル'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'fix_date', 'deleted_at'
    ];

    /**
     * ステータス文言
     */
    public function getStatusTextAttribute()
    {
        return Arr::get(self::STATUSES, $this->status);
    }

    /**
     * 未確認の注文か
     */
    public function getIsUnconfirmedAttribute()
    {
        return $this->status === self::STATUS_UNCONFIRMED;
    }

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
