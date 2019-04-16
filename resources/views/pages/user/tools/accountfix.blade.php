@extends('adminlte::page')

@section('title', 'Account Fix')

@section('content_header')
    <h1>Account Fix</h1>
@stop

@section('content')
<div class="box">
	<div class="box-body">
		<form method="post">
			@csrf
            @if(config('settings.reCaptchStatus'))
                <div class="g-recaptcha" data-sitekey="{{ config('settings.reCaptchSite') }}"></div>
            @endif
			<div class="form-group">
				<label>FIX YOUR ACCOUNT LOG IN STATE :</label>
				<button class="btn btn-flat btn-block btn-success" type="submit">FIX ACCOUNT</button>
			</div>
		</form>
	</div>
</div>
@stop

@section('css')

@stop

@section('js')
    @if(config('settings.reCaptchStatus'))
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
@stop