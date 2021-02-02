@extends('layouts.admin.app')

@section('content')
<div class="col-md-10">
    <div class="card">
        <div class="card-header">一覧画面</div>

        <div class="card-body">
			<div class="mb-1"><a class="btn btn-primary" href="{{ route('admin.items.add') }}" role="button">新規登録</a></div>
			@include('layouts.flash_message')
			@if ($items->count() != 0)
			<div class="mt-3">
				{{ $items->links() }}
			</div>
			<table class="table table-striped">
				<thead>
					<tr>
					<th scope="col">商品名</th>
					<th scope="col">画像</th>
					<th scope="col">価格</th>
					<th scope="col">説明文</th>
					<th scope="col">検索用タグ</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($items as $item)
					<tr>
					<td><a href="{{ route('admin.items.view', ['id' => $item->id]) }}">{{ $item->name }}</a></td>
					<td><img src="/uploads/items/{{ $item->id }}/{{ $item->img }}" width="50px" height="50px"></td>
					<td>{{ $item->price }}円</td>
					<td>{{ $item->description }}</td>
					<td>{{ $item->tag_for_search }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="mt-3">
				{{ $items->links() }}
			</div>
			@endif
        </div>
    </div>
</div>
@endsection
