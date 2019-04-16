@extends('adminlte::page')

@section('title', 'Profile Setting')

@section('content_header')
    <h1>Profile Setting</h1>
@stop

@section('content')
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">Avatar</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-3 col-md-offset-4">
				<center>
					<span style="text-decoration: underline;">CURRENT AVATAR</span><br>
					<img src="@if ($user->profile->avatar_status == True) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif" alt="{{ $user->name }}" class="img-circle" style="width: 160px;border: 1px solid #222">
				</center>
			</div>
			<div class="col-md-12">
				<form action="{{ URL('user/profile/avatar/upload') }}" method="post" enctype="multipart/form-data">
					@csrf
					<table style="padding: 0px;" class="table" table-border=0>
						<tbody>
							<tr>
								<td style="width: 90%">
									<div class="input-group">
										<span class="input-group-btn">
											<span class="btn btn-primary btn-file">
												Browse… <input type="file" name="file" id="imgInp">
											</span>
										</span>
										<input type="text" class="form-control" readonly placeholder="Upload new avatar.">
									</div>
								</td>
								<td>
									<button class="btn btn-success btn-block">UPLOAD</button>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">Informations</h3>
	</div>
	<div class="box-body">
		<div class="row">
			{!! Form::model($user->profile, ['method' => 'PATCH', 'route' => ['user.update.info', $user->name], 'id' => 'user_profile_form',  'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
				@csrf
				<div class="col-md-12">
					<div class="form-group">
						<label>FIRST NAME :</label>
						{!! Form::text('first_name', $user->first_name, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => 'Enter Your first name.')) !!}
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label>LAST NAME :</label>
						{!! Form::text('last_name', $user->last_name, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => 'Enter Your last name.')) !!}
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label>BIO :</label>
						{!! Form::textarea('bio', $user->profile->bio, array('id' => 'bio', 'class' => 'form-control', 'placeholder' => trans('profile.ph-bio'))) !!}
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
						<label>CURRENT PASSWORD :</label>
						<input type="password" name="password" class="form-control" placeholder="Enter your current password.">
					</div>
				</div>
				<div class="col-md-12">
					<button class="btn btn-success" type="submit">UPDATE</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@stop

@section('css')
<style type="text/css">
  .btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

#img-upload{
    width: 100%;
}
</style>
@stop

@section('js')
<script type="text/javascript">
$(document).ready(function(){function d(b){if(b.files&&b.files[0]){var a=new FileReader;a.onload=function(a){$("#img-upload").attr("src",a.target.result)};a.readAsDataURL(b.files[0])}}$(document).on("change",".btn-file :file",function(){var b=$(this),a=b.val().replace(/\\/g,"/").replace(/.*\//,"");b.trigger("fileselect",[a])});$(".btn-file :file").on("fileselect",function(b,a){var c=$(this).parents(".input-group").find(":text");c.length?c.val(a):a&&alert(a)});$("input#imgInp").change(function(){d(this)})});
</script>
@stop