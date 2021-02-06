<?php

namespace Helpers;

use App\Item;
use Illuminate\Support\Facades\Auth;


class ItemHelper {

    public static function getStatusLabel($item)
    {
        switch ($item->status) {
            case Item::STATUS_SALE:
                $class = 'badge badge-success font-large';
                $action = 'sale_stop';
                $onclick = "saleStopPost($item->id)";
                break;
            case Item::STATUS_SALE_STOP:
                $class = 'badge badge-secondary font-large';
                $action = 'sale';
                $onclick = "salePost($item->id)";
                break;
            default:
                return '';
        }

        if ($item->admin_id === Auth::id()) { // 自身の商品は変更可能
            $csrf = csrf_field();
            $form_action = route("admin.items.$action", ['id' => $item->id]);
            $id = 'form_' . $action . '_' . $item->id;
            $content =<<<EOD
            <div class="btn-group" role="group">
                <form action="$form_action" id="$id" method="post">
                $csrf
                <a href="#" data-id="$item->id" class="$class" onclick="$onclick;">$item->status_text</a>
                </form>
            </div>
            EOD;
        } else { // 他者の商品は変更不可
            $content =<<<EOD
            <div class="btn-group" role="group">
                <a href="#" data-id="$item->id" class="$class" onclick="uneditable();">$item->status_text</a>
            </div>
            EOD;
        }

        return $content;
    }
}
