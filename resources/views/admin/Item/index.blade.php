@extends('layouts.admin.app')

@section('content')
<div class="col-md-10">
    <div class="card">
        <div class="card-header">一覧画面</div>

        <div class="card-body">
			@include('layouts.flash_message')
			@if ($items->count() != 0)
			<div class="mt-3">
				{{ $items->links() }}
			</div>
			<table class="table table-striped">
				<thead>
					<tr>
					<th scope="col">商品名</th>
					<th scope="col">価格</th>
					<th scope="col">説明文</th>
					<th scope="col">検索用タグ</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($items as $item)
					<tr>
					<td><a href="{{ route('admin.items.view', ['id' => $item->id]) }}">{{ $item->name }}</a></td>
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
