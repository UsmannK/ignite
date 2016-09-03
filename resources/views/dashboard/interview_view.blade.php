@extends('layouts.app')

@section('top')
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">
@stop

@section('bottom_js')
<script type="text/javascript" src="{{asset('js/bootstrap-multiselect.js')}}"></script>
<script>
$("#confirm_send").click(function() {
    console.log("wat");
})
 $(document).ready(function() {
        $('.example-getting-started').multiselect();
    });
</script>
@stop

@section('content')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirm Sending</h4>
      </div>
      <div class="modal-body">
        Please confirm sending interview times.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-default" id="confirm_send">I'm sure I want to do this</button>
      </div>
    </div>
  </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif        
            <div class="panel panel-default">
                <div class="panel-heading">Viewing All Interview Timeslots</div>
                <div class="panel-body">
                    @role('admin')
                   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Send Interview Times</button>
                    <hr/>
                    @endrole('admin')
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Location</th>
                                <th>Students</th>
                                <th>Interview</th>
                                <th>Mentors</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($interviews as $interview)
                            <tr>
                                <td>{{$interview->formattedStartTime}}</td>
                                <td>{{$interview->formattedEndTime}}</td>
                                <td>{{$interview['location'] == '' ? 'TBA' : $interview['location']}}</td>
                                <td>{{$interview->applications}}</td>
                                @if($interview->applicationsID == '')
                                <td>-</td>
                                @else
                                <td><a href="{{action('PageController@showInterview')}}{{$interview->applicationsID}}">Multi-Interview &raquo;</a></td>
                                @endif
                                <td>
                                    <select class="example-getting-started" multiple="multiple">
                                        @foreach($interview->mentorsAssigned as $mentor)
                                            <option>{{$mentor['mentor']['name']}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
