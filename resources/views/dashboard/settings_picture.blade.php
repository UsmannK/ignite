@extends('layouts.app')

@section('bottom_js')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('js/cropper.min.js')}}"></script>
<script>
$(document).ready(function() {
    $('body').on('click', '#croppedSubmit', function () {
        $.ajax({
            type: 'POST',
            url: '{{action('PageController@cropPicture')}}',
            data: { "_token": "{{ csrf_token() }}", "src" : $("#image").attr("src"), "x" : $('#image').cropper("getData")['x'], "y" : $('#image').cropper("getData")['y'], "width": $('#image').cropper("getData")['width'], "height" : $('#image').cropper("getData")['height']},
            dataType: 'json',
            success: function(data) {
                if(data['message'] == 'success') {
                    window.location.href = '{{action('PageController@showSettings')}}';
                }
            }
        });
    });
    $('#settingsForm').submit(function(event) {
        $("#message").fadeOut();
        $.ajax({
            url: '{{action('PageController@tempProfilePicStore')}}',
            data: new FormData($("#settingsForm")[0]),
            dataType:'json',
              async:false,
              type:'post',
              processData: false,
              contentType: false,
              success:function(data){
                if(data['message'] == 'success') {
                    $("#message").fadeOut();
                    $("#settingsForm").fadeOut("normal", function() {
                        $(this).remove();
                    });
                    $("#image_holder").append('<button class="btn btn-success" id="croppedSubmit">Submit Photo</button><hr/><div><img id="image" src="' + data['location'] + '"></div>');
                    $('#image').cropper({
                        aspectRatio: 1/1,
                        viewMode: 1,
                        crop: function(e) {
                          // Output the result data for cropping image.
                          console.log(e.x);
                          console.log(e.y);
                          console.log(e.width);
                          console.log(e.height);
                        }
                    });
                } else {
                    $("#message").fadeIn().addClass('alert alert-danger').html(data);
                }
                console.log(data);
              },
            });
        event.preventDefault();
    });
});
</script>
@stop

@section('content')
<link href="{{asset('css/cropper.min.css')}}" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-md-12"> 
            <div class="panel panel-default">
                <div class="panel-heading">Manage Profile Picture</div>
                <div class="panel-body">
                    @if(Auth::user()->image)
                        <b>Current Photo:</b><br/>
                        <img src="{{asset('storage/' . Auth::user()->image)}}" class="img-thumbnail" style="max-width: 200px">
                        <hr/>
                    @endif
                    <div id="image_holder"></div>
                    <form id="settingsForm" method="POST" enctype="multipart/form-data">
                        <div id="message"></div>
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <label for="photoUpload">Please select a photo to upload.</label>
                        <input type="file" name="photo" id="photoUpload">
                        <hr/>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
