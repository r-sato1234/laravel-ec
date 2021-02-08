<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * 住所を取得する
     */
    public function getFullAddressAttribute()
    {
        $prefecture = Arr::get(config('pref'), $this->prefecture_id);

        return sprintf('〒%s ' . "\n" . '%s%s%s %s' , $this->zip, $prefecture, $this->address1, $this->address2, $this->address3);
    }
}
