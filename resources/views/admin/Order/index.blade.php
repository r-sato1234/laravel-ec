<?php
use App\Order;
use Helpers\OrderHelper;
?>

@extends('layouts.admin.app')

@section('head')
	@parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/>
  	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.ja.min.js"></script>
@endsection

@section('content')
<style>
	.font-large {
		font-size: 14px
	}
	.font-small {
		font-size: 13px
	}
	.list-order-wrap {
		padding-left: 0;
	}
	.list-order-wrap > li {
		list-style: none;
	}
	.list-order-wrap > li:last-child {
		padding-bottom: 0;
	}
	.table {
		width: 100%;
		margin-bottom: 0;
		color: #212529;
	}
</style>
<div class="col-md-10">
    <div class="card">
        <div class="card-header">一覧画面</div>

        <div class="card-body">
			@include('layouts.flash_message')
			<div class="card mb-2">
			<div class="card-header">検索</div>
			<div class="card-body">
			<form method="get">
			<div class="form-group">
				<p class="control-label d-inline"><b>ステータス&ensp;:&ensp;</b></p>
				<div class="form-inline d-inline">
				@foreach (Order::STATUSES as $key => $status)
				<?php
					$request_status = request()->query('status');
					$checked = ($request_status && in_array($key, $request_status)) ? 'checked="checked"' : null;
				?>
				<label class="checkbox-inline ml-1 d-inline">
					<input type="checkbox" name="status[]" value="{{ $key }}" {{ $checked }}>{{ $status }}
				</label>
				@endforeach
				</div>
			</div>
			<div class="form-group">
				<p class="control-label d-inline"><b>注文日時&ensp;:&ensp;</b></p>
				<div class="form-inline d-inline">
				<input class="date form-control" name="created_at_start" type="text" value="{{ request()->query('created_at_start') }}">&ensp;~&ensp;
				<input class="date form-control" name="created_at_end" type="text" value="{{ request()->query('created_at_end') }}">
				</div>
			</div>
			<div class="btn-toolbar mx-auto" style="width: 200px;" role="toolbar">
				<div class="btn-group mr-2" role="group">
				<button type="submit" class="btn btn-info">検索</button>
				</div>

				<div class="btn-group mr-2" role="group">
					<a class="btn btn-secondary" href="{{ route('admin.orders') }}" role="button">クリア</a>
				</div>
			</div>
			</form>
			</div>
			</div>
			@if ($orders->count() != 0)
			<div class="mb-3">
			<a href="{{ route('admin.orders.export', request()->query()) }}" class="btn btn-primary font-weight-bold" onclick="return confirm('売上CSVをダウンロードしますか？');"><i class="fas fa-download"></i>売上CSVダウンロード</a>
			</div>
			<div class="mt-3">
				{{ $orders->links() }}
			</div>

			<ul class="list-order-wrap">
				<li>
					<table class="table">
						<thead>
							<tr class="d-flex table-active">
							<th class="col-1">表示</th>
							<th class="col-3">注文番号</th>
							<th class="col-2">ステータス</th>
							<th class="col-3">注文者名</th>
							<th class="col-3">注文日時</th>
							</tr>
						</thead>
					</table>
				</li>

				@foreach ($orders as $order)
				<?php $sum = 0 ?>
				<li>
				<table class="table">
					<tbody>
						<tr class="d-flex">
						<td class="col-1"><a data-toggle="collapse" href="#collapse-{{ $order->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">▼</a></td>
						<td class="col-3"><a href="{{ route('admin.orders.view', ['id' => $order->id]) }}">{{ $order->order_code }}</a></td>
						<td class="col-2">{!!  OrderHelper::getStatusLabel($order) !!}</td>
						<td class="col-3">{{ $order->user()->getResults()->getAttribute('name') }}</td>
						<td class="col-3">{{ $order->created_at }}</td>
						</tr>
					</tbody>
				</table>
				<div id="collapse-{{ $order->id }}" class="collapse">
				<div class="card">
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
				</div>
				</li>
				@endforeach
			</ul>

			<div class="mt-3">
				{{ $orders->links() }}
			</div>
			@endif
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.date').datepicker({
	  language:'ja',
	  format: 'yyyy-mm-dd'
    });
</script>
@endsection
