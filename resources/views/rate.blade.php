@extends('layouts.app')

@section('bottom_js')
<script>
var submitted = false;
$(document).keyup(function(e) {
    var val;
    if(e.keyCode == 97 || e.keyCode == 49) {
        val = 1;
    } else if(e.keyCode == 98 || e.keyCode == 50) {
        val = 2;
    } else if(e.keyCode == 99 || e.keyCode == 51) {
        val = 3;
    }
    if(val && !submitted) {
        submitRating(val);
    }
});
$('#rating-group button').click(function() {
    if(!submitted) {
        submitRating($(this).attr("value"));
    }
});
function submitRating(value) {
    $.ajax({
        type: 'POST',
        url: '{{action('PageController@submitRating')}}',
        data: { "_token": "{{ csrf_token() }}", "rating": value, "app_id": '{{$data['id']}}'},
        dataType: 'json',
        success: function(data) {
            if(data['message'] == "success") {
                // Only allow submit once
                submitted = true;
                window.location.href = data.redirect;
            }
        }
    });
}
</script>
@stop

@section('content')
<style>
    .panel-body {
        font-size: 16px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if($rating)
                <div class="alert alert-info"><b>Heads up!</b> You've already rated this application a <b>{{$rating['rating']}}</b>.</div>
            @endif
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif
            <div class="text-center">
                <div class="btn-group" role="group" aria-label="rating" id="rating-group">
                    <button type="button" class="btn btn-{{$rating['rating'] == 1 ? 'primary' : 'default' }}" value="1">1</button>
                    <button type="button" class="btn btn-{{$rating['rating'] == 2 ? 'primary' : 'default' }}" value="2">2</button>
                    <button type="button" class="btn btn-{{$rating['rating'] == 3 ? 'primary' : 'default' }}" value="3">3</button>
                </div>
            </div>
            <br/>
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
