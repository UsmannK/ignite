@extends('layouts.app')

@section('content')
<style>
    .panel-body {
        font-size: 16px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif        
            <div class="panel panel-default">
                <div class="panel-heading">Viewing: {{$application['name']}}</div>
                <div class="panel-body">
                   <h1 style="margin-top: 0px;">{{$application['name']}} <small>({{$application['email']}})</small></h1>
                   <hr/>
                        <b>Tell us about yourself!</b><br/>
                        {{$application['q1']}}
                    <hr/>
                        <b>Why do you want to be part of Ignite? What do you hope to get out of the program?</b><br/>
                        {{$application['q2']}}
                    <hr/>
                        <b>Q: What is your programming experience?</b><br/>
                        {{$application['q3']}}
                    <hr/>
                        <b>What is one thing you'd like to learn this year?</b><br/>
                        {{$application['q4']}}
                    <hr/>
                        <b>Ignite focuses on both community building and skill development through a semester long project. What project would you like to work on?</b><br/>
                        {{$application['q5']}}
                    <hr/>                                                    
                        <b>What would your ideal mentor be like?</b><br/>
                        {{$application['q6']}}                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
