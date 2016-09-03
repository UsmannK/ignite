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
$('#interviewForm button').click(function() {
    $("#save_text").html('Saving...');
    var value = $(this).val();
    var button = $(this);
    var app_id = button.data('app');
    $.ajax({
        type: 'POST',
        url: '{{action('PageController@submitInterviewDecision')}}',
        data: { "_token": "{{ csrf_token() }}", "decision": value, "app_id": app_id},
        dataType: 'json',
        success: function(data) {
            if(data['message'] == "success") {
                // Visual feedback that request was successful
                $("#reject-" + app_id).removeClass("active").html("Reject");
                $("#standby-" + app_id).removeClass("active").html("Standby");
                $("#accept-" + app_id).removeClass("active").html("Accept");
                $(button).append(' <i class="fa fa-check" aria-hidden="true"></i>').addClass("active");
                if(data['message'] == 'success') {
                    $("#save_text").html('<abbr title="' + data['updated_at'] +'">Saved.</abbr>');
                }
            }
        }
    });
});
$('#interviewForm .displays-list').change(function() {
    $("#save_text").html('Saving...');
    var checkbox = $(this);
    var app_id = checkbox.data('app');
    var val = 0; 
    if($(this).is(":checked")) {
        val = 1;
    }
    $.ajax({
        type: 'POST',
        url: '{{action('PageController@submitInterviewAttribute')}}',
        data: { "_token": "{{ csrf_token() }}", "attribute": checkbox.attr('name'), "app_id": app_id, "value" : val},
        dataType: 'json',
        success: function(data) {
            if(data['message'] == 'success') {
                 $("#save_text").html('<abbr title="' + data['updated_at'] +'">Saved.</abbr>');
            };
        }
    });
       
});  
function saveToDB(app_id, data) {
    $("#save_text").html('Saving...');
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
                        <h4>{{$applications[$i]['name']}} <small><a href="{{action('PageController@showRate', ['id' => $applications[$i]['id']])}}">(Application)</a></small></h4>
                        <b>Notes:</b>
                    <form id="interviewForm">
                        <textarea name="notes" id="editor{{$i}}" rows="10" cols="80">{{$interviews[$i]['notes']}}</textarea>
                        <br/>
                        <div class="row">
                            <div class="col-md-6">
                            <b>I</b> would 
                                <button id="reject-{{$applications[$i]['id']}}" type="button" value="1" class="btn btn-danger btn-md text-left{{ ($interviews[$i]['decision'] == 1) ? ' active' : '' }}" data-app="{{$applications[$i]['id']}}">Reject{!! ($interviews[$i]['decision'] == 1) ? ' <i class="fa fa-check" aria-hidden="true"></i>' : '' !!}</button>
                                <button id="standby-{{$applications[$i]['id']}}" type="button" value="2" class="btn btn-warning btn-md text-left{{ ($interviews[$i]['decision'] == 2) ? ' active' : '' }}" data-app="{{$applications[$i]['id']}}">Standby{!! ($interviews[$i]['decision'] == 2) ? ' <i class="fa fa-check" aria-hidden="true"></i>' : '' !!}</button>
                                <button id="accept-{{$applications[$i]['id']}}" type="button" value="3" class="btn btn-success btn-md text-right{{ ($interviews[$i]['decision'] == 3) ? ' active' : '' }}" data-app="{{$applications[$i]['id']}}">Accept{!! ($interviews[$i]['decision'] == 3) ? ' <i class="fa fa-check" aria-hidden="true"></i>' : '' !!}</button>
                                this student
                            </div>
                            <div class="col-md-6 text-right">
                                Student displays: 
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="passion" data-app="{{$applications[$i]['id']}}" class="displays-list" data-app="{{$applications[$i]['id']}}" {{ ($interviews[$i]['passion'] == 1) ? ' checked' : '' }}> Passion
                                    </label>
                                    |
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="commitment" data-app="{{$applications[$i]['id']}}" class="displays-list" {{ ($interviews[$i]['commitment'] == 1) ? ' checked' : '' }}> Commitment
                                    </label>
                                    |
                                    <label class="checkbox-inline">
                                        <input type="checkbox" name="drive" data-app="{{$applications[$i]['id']}}" class="displays-list" {{ ($interviews[$i]['drive'] == 1) ? ' checked' : '' }}> Drive
                                    </label>
                       
                            </div>
                        </div>
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