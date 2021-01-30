<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * ログインしているユーザーの商品を取得する
     *
     * @param int $admin_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function findByAdminId($admin_id)
    {
        return $this->where('admin_id', $admin_id)->orderBy('id', 'desc');
    }
}
