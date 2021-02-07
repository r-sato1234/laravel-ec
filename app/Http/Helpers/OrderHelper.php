<?php

namespace Helpers;

use App\Order;
use Illuminate\Support\HtmlString;


class OrderHelper {

    public static function getStatusLabel($order)
    {
        switch ($order->status) {
            case Order::STATUS_UNCONFIRMED:
                $class = 'badge badge-secondary';
                break;
            case Order::STATUS_CONFIRMED:
                $class = 'badge badge-success';
                break;
            case Order::STATUS_DELIVERY_COMPLETED:
                $class = 'badge badge-primary';
                break;
            case Order::STATUS_CANCELLED:
                $class = 'badge badge-danger';
                break;
            default:
                return '';
        }

        $content =<<<EOD
        <span class="$class font-large">$order->status_text</span>
        EOD;

        return new HtmlString($content);
    }
}
