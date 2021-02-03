@extends('layouts.admin.app')

@section('content')
<style>
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
			@if ($orders->count() != 0)
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
				<li>
				<table class="table">
					<tbody>
						<tr class="d-flex">
						<td class="col-1"><a data-toggle="collapse" href="#collapse-{{ $order->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">▼</a></td>
						<td class="col-3"><a href="{{ route('admin.orders.view', ['id' => $order->id]) }}">{{ $order->order_code }}</a></td>
						<td class="col-2">{{ $order->status }}</td>
						<td class="col-3">{{ $order->user_id }}</td>
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
								<th scope="col"><span class="font-small">合計金額</span></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>いちご</td>
									<td>298</td>
									<td>1980</td>
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
@endsection
