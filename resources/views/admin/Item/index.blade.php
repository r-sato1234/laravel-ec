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
					<th scope="col">操作</th>
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
					<td>
					<div class="btn-toolbar" role="toolbar">
						<div class="btn-group mr-2" role="group">
							<a class="btn btn-info btn-sm" href="{{ route('admin.items.view', ['id' => $item->id]) }}" role="button">詳細</a>
						</div>
						@if (!$item->deleted_at)
						<div class="btn-group" role="group">
							<form action="{{ route('admin.items.delete', ['id' => $item->id]) }}" id="form_delete" method="post">
							{{ csrf_field() }}
							{{ method_field('delete') }}
							<a href="#" data-id="{{ $item->id }}" class="btn btn-danger btn-sm" onclick="deletePost();">削除</a>
							</form>
						</div>
						@endif
					</div>
					</td>
					<td>{{ $item->name }}</td>
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

<script>
function deletePost() {
  'use strict';

  if (confirm('本当に削除してもよろしいですか？')) {
    document.getElementById('form_delete').submit();
  }
}
</script>
@endsection
