@extends('layouts.app')

@section('bottom_js')
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script>
    @for($i = 0; $i < count($applications); $i++)
    var editor{{$i}} = CKEDITOR.replace('editor{{$i}}');
    var timeoutId{{$i}};
    editor{{$i}}.on('change', function() {
        console.log('Textarea Change');
        clearTimeout(timeoutId{{$i}});
        var root = $(this);
        root.data = this.getData();
        timeoutId{{$i}} = setTimeout(function() {
            saveToDB({{$applications[$i]['id']}},root.data);
        }, 1000);
    });
    @endfor
function saveToDB(app_id, data) {
    // $("#save_text").html("Saving...");
    console.log('Saving to the db');
    $.ajax({
        type: 'POST',
        url: '{{action('PageController@updateInterview')}}',
        data: { "_token": "{{ csrf_token() }}", "app_id": app_id, "notes":  data},
        dataType: 'json',
        success: function(data) {
            if(data['message'] == 'success') {
                 $("#save_text").html('<abbr title="' + data['updated_at'] +'">Saved.</abbr>');
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
                <div class="panel-heading">Interview</div>
                <div class="panel-body">
                    @for($i = 0; $i < count($applications); $i++)
                        <h4>{{$applications[$i]['name']}}</h4>
                        <b>Notes:</b>
                    <form id="interviewForm">
                        <textarea name="notes" id="editor{{$i}}" rows="10" cols="80">{{$interviews[$i]['notes']}}</textarea>
                    </form>
                    <hr/>
                    @endfor
                    <span id="save_text">Nothing saved yet.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection