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
            data: $(this).serialize()+'&'+$.param({ 'about': editor.getData() }),
            dataType: 'json',
            success: function(data) {
                if(data['message'] == 'success') {
                     $("#message").fadeIn().removeClass('alert-danger').addClass("alert alert-success").html("Successfully updated settings.");
                } else {
                    string = '';
                    $.each(data, function(key, value){
                        string += value + "<br/>";
                    });
                    $("#message").fadeIn().removeClass('alert-success').addClass("alert alert-danger").html(string);                    
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
                            <p class="help-block">A very short description of you</p>
                        </div>
                        <div class="form-group">
                            <label for="inputGithub">Github Username</label>
                            <input type="text" class="form-control" id="inputGithub" value="{{Auth::user()->github}}" name="github" placeholder="Github Username">
                            <p class="help-block">Not required.</p>
                        </div>
                        <div class="form-group">
                            <label for="inputWebsite">Website URL</label>
                            <input type="text" class="form-control" id="inputWebsite" value="{{Auth::user()->website}}" name="website" placeholder="My Portfolio Website">
                            <p class="help-block">Not required.</p>
                        </div>
                        <hr/>
                        <h3 style="margin-top:0px;">Social Links <small>(Not required)</small></h3>
                        <div class="form-group">
                            <label for="inputFB">Facebook Username</label>
                            <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-facebook-official" aria-hidden="true"></i></div>
                                <input type="text" class="form-control" id="inputFB" value="{{Auth::user()->fb}}" name="fb" placeholder="Facebook Username">
                            </div>
                            @role(['admin', 'mentor'])
                                <p class="help-block">Displayed on Ignite homepage.</p>
                            @endrole
                            @role(['mentee'])
                                <p class="help-block">Shown only to other community members.</p>
                            @endrole
                            <label for="inputFB">Instgram Username</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                                    <input type="text" class="form-control" id="inputFB" value="{{Auth::user()->instagram}}" name="instagram" placeholder="Instgram Username">
                             </div>
                            <p class="help-block">Shown only to other community members.</p>
              
                            <label for="inputFB">Snapchat Username</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-snapchat-square" aria-hidden="true"></i></div>
                                    <input type="text" class="form-control" id="inputFB" value="{{Auth::user()->snapchat}}" name="snapchat" placeholder="Snapchat Username">
                            </div>
                            <p class="help-block">Shown only to other community members.</p>
              
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label for="inputAbout">About Me:</label>
                            <textarea class="form-control" id="inputAbout">{{Auth::user()->about}}</textarea>
                            <p class="help-block">Introduce yourself, list organizations you're involved with, etc.</p>
                        </div>
                        @if(env('APP_PHASE') == 1)
                            @role(['admin', 'mentor'])
                                <hr/>
                                <div class="checkbox">
                                    <label>
                                        <input name="enable_keyboard" type="checkbox" {{(Auth::user()->enable_keyboard) ? 'checked' : ''}}> Enable keyboard control for Rating
                                    </label>
                                </div>
                            @endrole
                        @endif
                        <hr/>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
