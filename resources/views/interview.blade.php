@extends('layouts.app')

@section('bottom_js')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script>
    var editor = CKEDITOR.replace('editor1');
    var timeoutId;
    editor.on('change', function() {
        console.log('Textarea Change');
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function() {
            saveToDB();
        }, 1000);
    });

function saveToDB() {
    $("#save_text").html("Saving...");
    console.log('Saving to the db');
    $.ajax({
        type: 'POST',
        url: '{{action('PageController@updateInterview')}}',
        data: { "_token": "{{ csrf_token() }}", "app_id": {{$application['id']}}, "notes":  editor.getData()},
        dataType: 'json',
        success: function(data) {
            if(data['message'] == 'success') {
                 $("#save_text").html('<abbr title="' + data['updated_at']['date'] +'">Saved.</abbr>');
            }
        }
    });
}
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
                <div class="panel-heading">Interviewing {{$application['name']}}</div>
                <div class="panel-body">
                    <b>Notes:</b>
                    <form id="interviewForm">
                        <textarea name="notes" id="editor1" rows="10" cols="80">{{$interview['notes']}}</textarea>
                    </form>
                    <hr/>
                    <span id="save_text">Nothing saved yet.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
