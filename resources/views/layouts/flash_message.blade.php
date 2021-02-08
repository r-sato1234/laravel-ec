@if (Session::has('success'))
<?php
$message = Session::get('success');
Session::remove('success');
?>

<div class="alert alert-success">
    {!! nl2br(htmlspecialchars($message)) !!}
</div>
@endif

@if (Session::has('error'))
<?php
$message = Session::get('error');
Session::remove('error');
?>

<div class="alert alert-danger">
    {!! nl2br(htmlspecialchars($message)) !!}
</div>
@endif