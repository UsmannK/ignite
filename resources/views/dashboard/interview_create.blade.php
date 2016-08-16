@extends('layouts.app')

@section('bottom_js')
<script>
$(document).ready(function() {
    $('#interviewForm').submit(function(event) {
        $("#message").fadeOut().removeClass("alert alert-success");
        $.ajax({
            type: 'POST',
            url: '{{action('PageController@submitCreateInterview')}}',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data['message'] == 'success') {
                     $("#message").fadeIn().addClass("alert alert-success").html("Successfully added interview slots.");
                }
            }
        });
        event.preventDefault();
    });
});
</script>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif        
            <div class="panel panel-default">
                <div class="panel-heading">Create Interview Timeslot</div>
                <div class="panel-body">
                    <div id="message"></div>
                    <div class="alert alert-danger"><b>Warning!</b> Only use this functionality if you know what you're doing!</div>
                    <form id="interviewForm">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <div class="form-group">
                            <label for="inputStartDay">Start Date (DD/MM/YYYY)</label>
                            <input type="text" class="form-control" id="inputStartDay" placeholder="09/05/2016" name="start_day">
                        </div>
                        <div class="form-group">
                            <label for="inputEndDay">End Date (DD/MM/YYYY)</label>
                            <input type="text" class="form-control" id="inputEndDay" placeholder="09/09/2016" name="end_day">
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label for="inputStartTime">Start Time</label>
                            <input type="text" class="form-control" id="inputStartTime" placeholder="10" name="start_time">
                        </div>
                        <div class="form-group">
                            <label for="inputEndTime">End Time</label>
                            <input type="text" class="form-control" id="inputEndTime" placeholder="18" name="end_time">
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label for="inputIncrement">Increment between interviews (minutes)</label>
                            <input type="text" class="form-control" id="inputIncrement" placeholder="20" name="increment">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit &raquo;</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
