<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * 注文を取得
     */
    public function order()
    {
        return $this
            ->belongsTo('App\Order');
    }

    /**
     * 商品を取得
     */
    public function item()
    {
        return $this
            ->belongsTo('App\Item')
            ->select('name')
            ->withTrashed();
    }

    /**
     * 売上CSVダウンロード
     *
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function scopeSalesCsv(Builder $query, array $params): Builder
    {
        $query
            ->select(DB::raw('price, item_id, count(*) as item_count, sum(price) as sub_total_price'))
            ->groupBy('item_id', 'price')
            ->orderBy('item_id');

        if (empty($params)) {
            return $query;
        }

        $query->join('orders','orders.id','=','order_items.order_id');

        // 検索
        $status = Arr::get($params, 'status');
        if (!empty($status)) {
            $query->whereIn('orders.status', $status);
        }

        $created_at_start = Arr::get($params, 'created_at_start');
        if ($created_at_start) {
            $query->whereDate('orders.created_at', '>=', $created_at_start);
        }
        $created_at_end = Arr::get($params, 'created_at_end');
        if ($created_at_end) {
            $query->whereDate('orders.created_at', '<=', $created_at_end);
        }

        return $query;
    }
}
