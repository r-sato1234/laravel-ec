<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    const STATUS_SALE = 1; // 販売中
    const STATUS_SALE_STOP = 99; // 販売停止
    const STATUSES = [
        self::STATUS_SALE => '販売中',
        self::STATUS_SALE_STOP => '販売停止',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id', 'name', 'description', 'price', 'tag_for_search', 'img', 'status'
    ];

    /**
     * ステータス文言
     */
    public function getStatusTextAttribute()
    {
        return Arr::get(self::STATUSES, $this->status);
    }

    /**
     * 販売中か
     */
    public function getIsSaleAttribute()
    {
        return $this->status === self::STATUS_SALE;
    }

    /**
     * 販売停止か
     */
    public function getIsSaleStopAttribute()
    {
        return $this->status === self::STATUS_SALE_STOP;
    }

    /**
     * ログインしているユーザー製品か
     *
     * @param int $id
     * @param int $admin_id
     * @return bool
     */
    public function isAuthUserItem($id, $auth_id)
    {
        return $this
            ->where('id', $id)
            ->where('admin_id', $auth_id)
            ->exists();
    }

    /**
     * インサートするレコードのIDを取得する
     *
     * @return int
     */
    public function getInsertId()
    {
        return $this->orderBy('id', 'desc')->first()->getAttribute('id') + 1;
    }
}
