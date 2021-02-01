@extends('layouts.admin.app')

@section('content')
<div class="col-md-10">
    <div class="card">
        <div class="card-header">詳細画面</div>

        <div class="card-body">
			<table class="table">
				<tr>
				<td>商品名</td>
				<td>{{ $item->name }}</td>
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
			<a class="btn btn-secondary" href="{{ route('admin.items') }}" role="button">戻る</a>
        </div>
    </div>
</div>
@endsection
