<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * 商品を取得
     */
    public function item()
    {
        return $this
            ->belongsTo('App\Item')
            ->select('name');
    }
}
