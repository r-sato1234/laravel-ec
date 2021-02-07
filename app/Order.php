<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const STATUS_UNCONFIRMED = 1; // 未確認
    const STATUS_CONFIRMED = 2; // 注文確定
    const STATUS_DELIVERY_COMPLETED = 3; // 配送完了
    const STATUS_CANCELLED = 99; // キャンセル
    const STATUSES = [
        self::STATUS_UNCONFIRMED => '未確認',
        self::STATUS_CONFIRMED => '注文確定',
        self::STATUS_DELIVERY_COMPLETED => '配送完了',
        self::STATUS_CANCELLED => 'キャンセル'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'fix_date', 'delivery_completed_date', 'deleted_at'
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
     * 確定の注文か
     */
    public function getIsConfirmedAttribute()
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    /**
     * 注文製品を取得
     */
    public function orderItems()
    {
        return $this
            ->hasMany('App\OrderItem')
            ->select(DB::raw('price, item_id, count(*) as item_count, sum(price) as sub_total_price'))
            ->groupBy('item_id', 'price')
            ->withTrashed();
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

    /**
     * 注文削除時はステータスを変更して、注文商品も削除する
     */
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($order) {
            $order->fill(['status' => self::STATUS_CANCELLED]);
            $order->save();
            $order->orderItems()->delete();
        });
    }

    /**
     * 検索
     *
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function scopeSerach(Builder $query, array $params): Builder
    {
        $query->withTrashed()->orderBy('id', 'desc');

        if (empty($params)) {
            return $query;
        }

        $status = Arr::get($params, 'status');
        if (!empty($status)) {
            $query->whereIn('status', $status);
        }

        $created_at_start = Arr::get($params, 'created_at_start');
        if ($created_at_start) {
            $query->whereDate('created_at', '>=', $created_at_start);
        }
        $created_at_end = Arr::get($params, 'created_at_end');
        if ($created_at_end) {
            $query->whereDate('created_at', '<=', $created_at_end);
        }

        return $query;
    }
}
