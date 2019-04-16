@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@php
use App\Models\User;
@endphp

@section('content')
{{ date('F d, Y h:i A',strtotime(Auth::user()->UserInfo4()->first()->LastLoginDate)) }}
@stop