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
        <div class="card-header">詳細画面</div>

        <div class="card-body">
			@include('layouts.flash_message')
			<table class="table">
				<tr>
				<td>販売ステータス</td>
				<td>{!!  ItemHelper::getStatusLabel($item) !!}</td>
				</tr>

				<td>商品名</td>
				<td>{{ $item->name }}</td>
				</tr>

				<tr>
				<td>画像</td>
				<td>
					@if ($item->img)
					<img src="/uploads/items/{{ $item->id }}/{{ $item->img }}" width="200px" height="200px">
					@endif
				</td>
				</tr>

				<tr>
				<td>価格</td>
				<td>{{ $item->price }}円</td>
				</tr>

				<tr>
				<td>説明文</td>
				<td>{{ $item->description }}</td>
				</tr>

				<tr>
				<td>検索用タグ</td>
				<td>{{ $item->tag_for_search }}</td>
				</tr>
			</table>
			<div class="btn-toolbar" role="toolbar">
				<div class="btn-group mr-2" role="group">
					<a class="btn btn-secondary" href="{{ route('admin.items') }}" role="button">戻る</a>
				</div>
				@if ($item->admin_id === Auth::id())
				<div class="btn-group mr-2" role="group">
					<a class="btn btn-primary" href="{{ route('admin.items.edit', ['id' => $item->id]) }}" role="button">編集</a>
				</div>
				@endif
			</div>
        </div>
    </div>
</div>

<script>
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
