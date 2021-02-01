@extends('layouts.admin.app')
@section('content')
<div class="col-md-10">
    <div class="card">
        <div class="card-header">
		<?php
		$is_create = (!isset($id)); ?>
		@if ($is_create)
			<?php $action = route('admin.items.create'); ?>
			{{ '新規登録' }}
		@else
			<?php $action = route('admin.items.update', ['id' => $id]); ?>
			{{ '編集' }}
		@endisset
		</div>
        <div class="card-body">
			@include('layouts.flash_message')
			@if ($errors->any())
				<?php
				$name = old('name');
				$description = old('description');
				$price = old('price');
				$tag_for_search = old('tag_for_search');
				?>
			@else
				<?php
				$name = $item->name;
				$description = $item->description;
				$price = $item->price;
				$tag_for_search = $item->tag_for_search;
				?>
			@endif

			<form method="post" action="{{ $action }}">
				{{ csrf_field() }}
				<table class="table">
					<tr>
					<td>商品名</td>
					<td>
						<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $name }}">
						@error('name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
					</tr>

					<tr>
					<td>価格</td>
					<td>
						<input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ $price }}">
						@error('price')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
					</tr>

					<tr>
					<td>説明文</td>
					<td>
						<textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ $description }}</textarea>
						@error('description')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
					</tr>

					<tr>
					<td>検索用タグ</td>
					<td>
						<input type="text" name="tag_for_search" class="form-control @error('tag_for_search') is-invalid @enderror" value="{{ $tag_for_search }}">
						@error('tag_for_search')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
					</tr>
				</table>

				<div class="btn-toolbar" role="toolbar">
				<div class="btn-group mr-2" role="group">
					<a class="btn btn-secondary" href="{{ route('admin.items') }}" role="button">一覧へ戻る</a>
				</div>

				<div class="btn-group mr-2 ml-auto" role="group" margin-left=auto;>
					<button class="btn btn-success" type="submit">登録</button>
				</div>
			</div>
			</form>
        </div>
    </div>
</div>
@endsection
