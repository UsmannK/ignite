@extends('layouts.app')

@section('bottom_js')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script>
$(document).ready(function() {
    $('#settingsForm').submit(function(event) {
        $("#message").fadeOut().removeClass("alert alert-success");
        $.ajax({
            type: 'POST',
            url: '{{action('PageController@submitSettings')}}',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                if(data['message'] == 'success') {
                     $("#message").fadeIn().addClass("alert alert-success").html("Successfully updated settings.");
                }
            }
        });
        event.preventDefault();
    });

    var editor = CKEDITOR.replace('inputAbout');
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
                <div class="panel-heading">Settings</div>
                <div class="panel-body">
                    <div id="message"></div>
                    <form id="settingsForm">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <div class="form-group">
                            <label for="inputName">Full Name</label>
                            <input type="text" class="form-control" id="inputName" value="{{Auth::user()->name}}" name="name" placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <label for="inputTagline">Tagline</label>
                            <input type="text" class="form-control" id="inputTagline" value="{{Auth::user()->tagline}}" name="tagline" placeholder="Tagline">
                        </div>
                        <div class="form-group">
                            <label for="inputAbout">About Me:</label>
                            <textarea class="form-control" id="inputAbout" value="{{Auth::user()->about}}" name="about"></textarea>
                            <p class="help-block">Introduce yourself, list organizations you're involved with, etc.</p>
                        </div>
                        
                        <hr/>
                        <div class="checkbox">
                            <label>
                                <input name="enable_keyboard" type="checkbox" {{(Auth::user()->enable_keyboard) ? 'checked' : ''}}> Enable keyboard control for Rating
                            </label>
                        </div>
                        <hr/>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
