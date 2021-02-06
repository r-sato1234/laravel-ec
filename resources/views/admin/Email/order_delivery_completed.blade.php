{{ $order->user()->getResults()->name }}様

ご注文いただきありがとうございます。
下記の注文を配送完了いたしました。

注文番号 : {{ $order->order_code }}
注文日時 : {{ $order->created_at }}
注文商品 :
------------------------------------------------------------------
<?php $sum = 0 ?>
@foreach ($order->orderItems()->getResults() as $order_item)
<?php
$name = $order_item->item()->getResults()->getAttribute('name');
$count = $order_item->getAttribute('item_count');
$price = $order_item->getAttribute('price');
$sub_total_price = $order_item->getAttribute('sub_total_price');
$sum += $sub_total_price;
?>
{{ $name }}({{ $price }}円) × {{ $count }} = {{ $sub_total_price }}円
@endforeach

合計金額 : {{ $sum }}円
------------------------------------------------------------------