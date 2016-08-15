@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif        
            <div class="panel panel-default">
                <div class="panel-heading">Interviewing {{$application['name']}}</div>
                <div class="panel-body"></div>
            </div>
        </div>
    </div>
</div>
@endsection