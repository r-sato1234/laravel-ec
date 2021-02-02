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
