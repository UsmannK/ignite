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
                    <button type="button" class="btn btn-{{$rating['rating'] == 1 ? 'primary' : 'default' }}" value="1">1</button>
                    <button type="button" class="btn btn-{{$rating['rating'] == 2 ? 'primary' : 'default' }}" value="2">2</button>
                    <button type="button" class="btn btn-{{$rating['rating'] == 3 ? 'primary' : 'default' }}" value="3">3</button>
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
                    @role('admin')
                        <hr/>
                         <div class="btn btn-danger btn-lg text-left">Reject</div>
                        <div class="btn btn-success btn-lg text-right">Accept</div>
                    @endrole
                </div>
            </div>
        </div>
        <div class="col-md-5">
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
                                            <option value="{{$slot['id']}}" selected>{{$slot->formattedStartTime}}</option>
                                        @else
                                            <option value="{{$slot['id']}}">{{$slot->formattedStartTime}}</option>
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
                            <div class="panel panel-default">
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
