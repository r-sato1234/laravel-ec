@if (Session::has('success'))
<div class="alert alert-success">
    {!! nl2br(htmlspecialchars(Session::get('success'))) !!}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger">
    {!! nl2br(htmlspecialchars(Session::get('error'))) !!}
</div>
@endif