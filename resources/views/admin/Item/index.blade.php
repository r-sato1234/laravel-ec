<?php
use Helpers\ItemHelper;
?>

@extends('layouts.admin.app')

@section('content')

<style>
	.font-large {
		font-size: 14px
	}
</style>

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
					<th scope="col">販売ステータス</th>
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
						@if ($item->admin_id === Auth::id() && !$item->deleted_at)
						<div class="btn-group" role="group">
							<?php
								$form_id = "form_delete_$item->id";
								$onclick = "deletePost($item->id)";
							?>
							<form action="{{ route('admin.items.delete', ['id' => $item->id]) }}" id="{{ $form_id }}" method="post">
							{{ csrf_field() }}
							{{ method_field('delete') }}
							<a href="#" data-id="{{ $item->id }}" class="btn btn-danger btn-sm" onclick="{{ $onclick }};">削除</a>
							</form>
						</div>
						@endif
					</div>
					</td>
					<td>{!!  ItemHelper::getStatusLabel($item) !!}</td>
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
function deletePost($id) {
  'use strict';
  let form_id = 'form_delete_' + $id;

  if (confirm('本当に削除してもよろしいですか？')) {
    document.getElementById(form_id).submit();
  }
}

function salePost($id) {
  'use strict';
  let form_id = 'form_sale_' + $id;

  if (confirm('本当に販売中に変更してもよろしいですか？')) {
    document.getElementById(form_id).submit();
  }
}

function saleStopPost($id) {
  'use strict';
  let form_id = 'form_sale_stop_' + $id;

  if (confirm('本当に販売停止に変更してもよろしいですか？')) {
    document.getElementById(form_id).submit();
  }
}

function uneditable() {
  'use strict';

  if (confirm('この商品はステータス変更できません')) {
    return;
  }
}
</script>
@endsection
