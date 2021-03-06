@extends('layouts.app')

@section('bottom_js')
<script>
var submitted = false;
@if(Auth::user()->enable_keyboard)
$(document).keyup(function(e) {
    var val;
    if(e.keyCode == 97 || e.keyCode == 49) { // 1 key
        val = 1;
    } else if(e.keyCode == 98 || e.keyCode == 50) { // 2 key
        val = 2;
    } else if(e.keyCode == 99 || e.keyCode == 51) { // 3 key
        val = 3;
    }
    if(val && !submitted) {
        submitRating(val);
    }
});
@endif
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
                $('<div class="modal-backdrop" style="background:#fff"></div>').appendTo(document.body).hide().fadeIn();
                submitted = true;
                window.location.href = data.redirect;
            }
        }
    });
}
@role('admin')
$('#timeslotForm').submit(function(event) {
    $.ajax({
        type: 'POST',
        url: '{{action('PageController@submitTimeslot')}}',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(data) {
            if(data['message'] == 'success') {
                console.log('success');
                 $("#message").fadeIn().addClass("alert alert-success").html("Successfully assigned interview slot.");
            }
        }
    });
    event.preventDefault();
});

$('#decisionForm button').click(function() {
    var value = $(this).val();
    var button = $(this);
    $.ajax({
        type: 'POST',
        url: '{{action('PageController@submitDecision')}}',
        data: { "_token": "{{ csrf_token() }}", "decision": value, "app_id": '{{$data['id']}}'},
        dataType: 'json',
        success: function(data) {
            if(data['message'] == "success") {
                // Visual feedback that request was successful
                $("#reject").removeClass("active").html("Reject");
                $("#standby").removeClass("active").html("Standby");
                $("#accept").removeClass("active").html("Accept");
                $(button).append(' <i class="fa fa-check" aria-hidden="true"></i>').addClass("active");
            }
        }
    });
});
@endrole
</script>
@stop

@section('content')
<style>.panel-body {font-size: 16px;}</style>
<div class="container">
    <div class="row">
        <div class="col-md-7">
            @if($rating)
                <div class="alert alert-info"><b>Heads up!</b> You've already rated this application a <b>{{$rating['rating']}}</b>.</div>
            @endif
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif
            <div class="text-center">
                <div class="btn-group" role="group" aria-label="rating" id="rating-group">
                    <button type="button" class="btn btn-{{$rating['rating'] == 1 ? 'primary' : 'default' }}" value="1">1 <i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-{{$rating['rating'] == 2 ? 'primary' : 'default' }}" value="2">2 <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-{{$rating['rating'] == 3 ? 'primary' : 'default' }}" value="3">3 <i class="fa fa-heart-o" aria-hidden="true"></i></button>
                </div>
            </div>
            <br/>
            <div class="panel panel-default">
                <div class="panel-heading">Application</div>
                <div class="panel-body">
                   <h1 style="margin-top: 0px;">{{$application['name']}} <small>({{$application['email']}})</small></h1>
                   <hr/>
                        <b>Tell us about yourself!</b><br/>
                        {{$application['q1']}}
                    <hr/>
                        <b>Why do you want to be part of Ignite? What do you hope to get out of the program?</b><br/>
                        {{$application['q2']}}
                    <hr/>
                        <b>What is your programming experience?</b><br/>
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
                    @role('admin')
                        <hr/>
                        <div class="text-center">
                            <form id="decisionForm">
                                <button id="reject" type="button" value="0" class="btn btn-danger btn-lg text-left{{ ($application['accepted'] == 0) ? ' active' : '' }}">Reject{!! ($application['accepted'] == 0) ? ' <i class="fa fa-check" aria-hidden="true"></i>' : '' !!}</button>
                                <button id="standby" type="button" value="-1" class="btn btn-warning btn-lg text-right{{ ($application['accepted'] == -1) ? ' active' : '' }}">Standby{!! ($application['accepted'] == -1) ? ' <i class="fa fa-check" aria-hidden="true"></i>' : '' !!}</button>
                                <button id="accept" type="button" value="1" class="btn btn-success btn-lg text-right{{ ($application['accepted'] == 1) ? ' active' : '' }}">Accept{!! ($application['accepted'] == 1) ? ' <i class="fa fa-check" aria-hidden="true"></i>' : '' !!}</button>
                            </form>
                        </div>
                    @endrole
                    @role('mentor')
                        <hr/>
                        <div class="text-center">
                            <form id="decisionForm">
                                <button id="reject" type="button" value="0" class="btn btn-danger btn-lg text-left{{ ($application['accepted'] == 0) ? ' active' : '' }}" disabled>Reject{!! ($application['accepted'] == 0) ? ' <i class="fa fa-check" aria-hidden="true"></i>' : '' !!}</button>
                                <button id="standby" type="button" value="-1" class="btn btn-warning btn-lg text-right{{ ($application['accepted'] == -1) ? ' active' : '' }}" disabled>Standby{!! ($application['accepted'] == -1) ? ' <i class="fa fa-check" aria-hidden="true"></i>' : '' !!}</button>
                                <button id="accept" type="button" value="1" class="btn btn-success btn-lg text-right{{ ($application['accepted'] == 1) ? ' active' : '' }}" disabled>Accept{!! ($application['accepted'] == 1) ? ' <i class="fa fa-check" aria-hidden="true"></i>' : '' !!}</button>
                            </form>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
        <div class="col-md-5">
        	<div class="panel panel-default">
        	    <div class="panel-heading">Rating Guide</div>
                <div class="panel-body">
                	<i class="fa fa-thumbs-o-down" aria-hidden="true"></i> - Does not display passion, interest. <i>(No)</i><br/>
				 	<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> - May be good for Ignite, need more info. <i>(Maybe)</i><br/>
 					<i class="fa fa-heart-o" aria-hidden="true"></i> - Passionate student, a great fit for Ignite. <i>(Yes)</i>
 					<br/><br/>
 					Most students will fall in the <b>2 (<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>)</b> range, only a few applicants will be a <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> or <i class="fa fa-heart-o" aria-hidden="true"></i>.
 					<hr/>
 					You should be looking for passion and interest in the applications (as much as you can with text). Experience <b>should not</b> play a large role when rating.
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Interview</div>
                <div class="panel-body">
                    @role('admin')
                        <div id="message"></div>
                        <form id="timeslotForm">
                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                             <input type="hidden" name="id" value="{{$application['id']}}" />
                            <div class="form-group">
                                <label for="inputTimeslot">Assign Interview Timeslot</label>
                                <select class="form-control" name="timeslot">
                                    @if($application['interview_timeslot'] == 0)
                                        <option selected disabled>Please select a slot</option>
                                    @endif
                                    @foreach($slots as $slot)
                                        @if($slot['id'] == $application['interview_timeslot'])
                                            <option value="{{$slot['id']}}" selected>{{$slot->formattedStartTime}} - ({{$slot->applicationsCount}})</option>
                                        @else
                                            <option value="{{$slot['id']}}">{{$slot->formattedStartTime}} - ({{$slot->applicationsCount}})</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                        <hr/>
                    @endrole
                    @if($interviews)
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        Mentor Interviews:<br/><br/>
                        @for ($i = 0; $i < count($interviews); $i++)
                            @if($interviews[$i]['decision'] == 3)
                                <div class="panel panel-success">
                            @elseif($interviews[$i]['decision'] == 2)
                                <div class="panel panel-warning">
                            @elseif($interviews[$i]['decision'] == 1)
                                <div class="panel panel-danger">
                            @else
                                <div class="panel panel-default">
                            @endif
                                <div class="panel-heading" role="tab">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$i}}">
                                            {{$interviews[$i]['author']}}
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-{{$i}}" class="panel-collapse collapse" role="tabpanel">
                                    <div class="panel-body">
                                        {!!$interviews[$i]['notes']!!}
                                        <hr/>
                                        @if($interviews[$i]['decision'] == 3)
                                            <b>Accept</b>
                                        @elseif($interviews[$i]['decision'] == 2)
                                            <b>Standby</b>
                                        @elseif($interviews[$i]['decision'] == 1)
                                            <b>Deny</b>
                                        @endif
                                        <br/>
                                        <label class="checkbox-inline">
                                        <input type="checkbox" disabled {{ ($interviews[$i]['passion'] == 1) ? 'checked' : '' }}>
                                        Passion
                                        </label>
                                        <label class="checkbox-inline">
                                        <input type="checkbox" disabled {{ ($interviews[$i]['commitment'] == 1) ? 'checked' : '' }}>
                                        Commitment
                                        </label>
                                        <label class="checkbox-inline">
                                        <input type="checkbox" disabled {{ ($interviews[$i]['drive'] == 1) ? 'checked' : '' }}>
                                        Drive
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endfor
                        </div>
                    @else
                    <div class="alert alert-warning">No Interview data yet!</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
