<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id', 'name', 'description', 'price', 'tag_for_search', 'img',
    ];

    /**
     * ログインしているユーザーの商品一覧を取得する
     *
     * @param int $admin_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function findByAdminId($admin_id)
    {
        return $this->where('admin_id', $admin_id)->orderBy('id', 'desc');
    }

    /**
     * ログインしているユーザーの商品詳細を取得する
     *
     * @param int $admin_id
     * @param int $id
     * @return App\Item
     */
    public function findByAdminIdAndId($admin_id, $id)
    {
        return $this->findByAdminId($admin_id)
            ->where('id', $id)
            ->first();
    }
}
