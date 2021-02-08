<?php
use Helpers\OrderHelper;
?>

@extends('layouts.admin.app')

@section('content')
<style>
	.font-large {
		font-size: 15px
	}
</style>

<div class="col-md-10">
    <div class="card">
        <div class="card-header">詳細画面</div>

        <div class="card-body">
			@include('layouts.flash_message')
			<table class="table">
				<tr>
				<td>注文番号</td>
				<td>{{ $order->order_code }}</td>
				</tr>

				<tr>
				<td>ステータス</td>
				<td>
				{{ $order->status_text }}
				@if ($order->is_unconfirmed)
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group mr-2" role="group">
						<form action="{{ route('admin.orders.fix', ['id' => $order->id]) }}" id="form_fix" method="post">
						{{ csrf_field() }}
						<a href="#" data-id="{{ $order->id }}" class="btn btn-success btn-sm" onclick="fixPost();">注文確定</a>
						</form>
					</div>
					<div class="btn-group mr-2" role="group">
						<form action="{{ route('admin.orders.cancel', ['id' => $order->id]) }}" id="form_cancel" method="post">
						{{ csrf_field() }}
						{{ method_field('delete') }}
						<a href="#" data-id="{{ $order->id }}" class="btn btn-danger btn-sm" onclick="cancelPost();">キャンセル</a>
						</form>
					</div>
				</div>
				@endif
				</td>
				</tr>

				<tr>
				<td>注文日時</td>
				<td>{{ $order->created_at }}</td>
				</tr>

				@if ($order->fix_date)
				<tr>
				<td>注文確定日時</td>
				<td>{{ $order->fix_date }}</td>
				</tr>
				@endif

				@if ($order->delivery_completed_date)
				<tr>
				<td>配送完了日時</td>
				<td>{{ $order->delivery_completed_date }}</td>
				</tr>
				@endif

				@if ($order->deleted_at)
				<tr>
				<td>キャンセル日時</td>
				<td>{{ $order->deleted_at }}</td>
				</tr>
				@endif
			</table>

			<p class="h3">配送先</p>
			@if ($order->is_confirmed)
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group mb-2" role="group">
						<form action="{{ route('admin.orders.deliveryComplete', ['id' => $order->id]) }}" id="form_delivery_complete" method="post">
						{{ csrf_field() }}
						<a href="#" data-id="{{ $order->id }}" class="btn btn-primary btn-sm" onclick="deliveryCompletePost();">配送完了メール送信</a>
						</form>
					</div>
				</div>
				@endif
			<table class="table">
				<tr>
				<td>注文者名</td>
				<td>{{ $order->user()->getResults()->name }}</td>
				</tr>

				<tr>
				<td>住所</td>
				<td>{!! nl2br(e($order->address()->getResults()->full_address)) !!}</td>
				</tr>
			</table>

			<p class="h3">注文商品</p>
			<div class="card mb-2">
				<div class="card-body">
						<table class="table table-striped mb-0">
							<thead>
								<tr>
								<th scope="col"><span class="font-small">商品名</span></th>
								<th scope="col"><span class="font-small">金額</span></th>
								<th scope="col"><span class="font-small">数量</span></th>
								<th scope="col"><span class="font-small">小計</span></th>
								</tr>
							</thead>
							<tbody>
								<?php $sum = 0 ?>
								@foreach ($order->orderItems()->getResults() as $order_item)
								<?php $sum += $order_item->getAttribute('sub_total_price') ?>
								<tr>
									<td>{{ $order_item->item()->getResults()->getAttribute('name') }}</td>
									<td>{{ $order_item->getAttribute('price') }}</td>
									<td>{{ $order_item->getAttribute('item_count') }}</td>
									<td>{{ $order_item->getAttribute('sub_total_price') }}</td>
								</tr>
								@endforeach
								<tr>
									<td colspan="3" class="font-weight-bold">合計</td>
									<td>{{ $sum }}</td>
								</tr>
							</tbody>
						</table>
				</div>
			</div>

			<div class="btn-toolbar" role="toolbar">
				<div class="btn-group mr-2" role="group">
					<a class="btn btn-secondary" href="{{ route('admin.orders') }}" role="button">戻る</a>
				</div>
			</div>
        </div>
    </div>
</div>

<script>
function cancelPost() {
  'use strict';

  if (confirm('本当にキャンセルしてもよろしいですか？')) {
    document.getElementById('form_cancel').submit();
  }
}

function fixPost() {
  'use strict';

  if (confirm('本当に確定してもよろしいですか？')) {
    document.getElementById('form_fix').submit();
  }
}

function deliveryCompletePost() {
  'use strict';

  if (confirm('本当に配送完了メールを送信してもよろしいですか？')) {
    document.getElementById('form_delivery_complete').submit();
  }
}

</script>
@endsection
