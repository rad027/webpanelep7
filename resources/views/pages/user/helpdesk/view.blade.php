@extends('adminlte::page')

@section('title', 'Viewing Ticket #'.$hd->id.' by ['.( Auth::user()->name == $hd->user()->first()->name ? 'You' : $hd->user()->first()->name).']')

@section('content_header')
    <h1>Viewing Ticket #{{ $hd->id }} by [{{ ( Auth::user()->name == $hd->user()->first()->name ? 'You' : $hd->user()->first()->name) }}]</h1>
@stop

@php
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
@endphp

@section('content')
<div class="box box-primary direct-chat direct-chat-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
        	{{ $hd->title }}
        </h3>
        <span class="pull-right">
        	@if(Auth::user()->isAdmin())
        	<a href="{{ url('helpdesk') }}" class="btn btn-xs btn-flat btn-danger">BACK TO LIST</a>
        	@else
        	<a href="{{ url('user/helpdesk') }}" class="btn btn-xs btn-flat btn-danger">BACK TO LIST</a>
        	@endif
        </span>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    	@foreach($hd->helpdeskconversation()->cursor() as $hdd)
    		
		        <!-- Conversations are loaded here -->
		        <div class="direct-chat-messages">
		        	@if($hdd->user_id == Auth::user()->id)
		        		@php
		        			$receiver = $hdd->user_id;
		        		@endphp
			            <!-- Message. Default to the left -->
			            <div class="direct-chat-msg right">
			                <div class="direct-chat-info clearfix">
			                    <span class="direct-chat-name pull-left">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
			                    <span class="direct-chat-timestamp pull-right">{{ date('M d,Y h:i A',strtotime($hdd->created_at)) }}</span>
			                </div>
			                <!-- /.direct-chat-info -->
			                <img class="direct-chat-img" src="@if (Auth::user()->profile()->count() && Auth::user()->profile()->first()->avatar_status == True) {{ Auth::user()->profile()->first()->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif" alt="Message User Image">
			                <!-- /.direct-chat-img -->
			                <div class="direct-chat-text">
			                    <?= strip_tags(nl2br($hdd->message),'<br><br />') ?>
			                </div>
			                <!-- /.direct-chat-text -->
			            </div>
			            <!-- /.direct-chat-msg -->
		            @else
		            <!-- Message to the right -->
		            	@if($hdd->user_id != 0)
				            @php
				            	try{
				            		$sender = User::findOrFail($hdd->user_id);
				            		$receiver = $hdd->user_id;
				            @endphp
					            <div class="direct-chat-msg">
					                <div class="direct-chat-info clearfix">
					                    <span class="direct-chat-name pull-right">{{ $sender->first_name }} {{ $sender->last_name }}</span>
					                    <span class="direct-chat-timestamp pull-left">{{ date('M d,Y h:i A',strtotime($hdd->created_at)) }}</span>
					                </div>
					                <!-- /.direct-chat-info -->
					                <img class="direct-chat-img" src="@if ($sender->profile()->count() && $sender->profile()->first()->avatar_status == True) {{ $sender->profile()->first()->avatar }} @else {{ Gravatar::get(Auth::user()->email) }} @endif" alt="Message User Image">
					                <!-- /.direct-chat-img -->
					                <div class="direct-chat-text">
			                    		<?= strip_tags(nl2br($hdd->message),'<br><br />') ?>
					                </div>
					                <!-- /.direct-chat-text -->
					            </div>
					            <!-- /.direct-chat-msg -->
				            @php
				            	}catch(ModelNotFoundException $e){
				            		echo "Receivers information cannot find.";
				        		}
				            @endphp
				        @endif
		            @endif
		        </div>
		        <!--/.direct-chat-messages-->
        	
        @endforeach
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <form action="{{ ( Auth::user()->isUser() ? url('user/helpdesk/view/'.$hd->id.'/0') : url('helpdesk/view/'.$hd->id.'/0') ) }}" method="post">
        	@csrf
            <div class="input-group">
                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat">reply</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /.box-footer-->
</div>
@stop

@section('css')
<style type="text/css">
.direct-chat-messages {
	height: auto!important;
	min-height: 100px;
	overflow: visible;
}
</style>
@stop

@section('js')

@stop