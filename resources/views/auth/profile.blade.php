@extends('layouts.default')
    @section('content')
        @include('includes.alert')
        <h2>Hello {{$user->name}}</h2>
        <h2>Your Email: <em>{{$user->email}}</em></h2>
@stop