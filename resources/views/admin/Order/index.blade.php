@extends('layouts.admin.app')

@section('content')
<div class="col-md-10">
    <div class="card">
        <div class="card-header">一覧画面</div>

        <div class="card-body">
			@include('layouts.flash_message')
			@if ($orders->count() != 0)
			<div class="mt-3">
				{{ $orders->links() }}
			</div>
			<table class="table table-striped">
				<thead>
					<tr>
					<th scope="col">注文</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($orders as $item)
					<tr>
					<td>test</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="mt-3">
				{{ $orders->links() }}
			</div>
			@endif
        </div>
    </div>
</div>
@endsection
