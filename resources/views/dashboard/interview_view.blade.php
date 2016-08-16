@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif        
            <div class="panel panel-default">
                <div class="panel-heading">Viewing All Interview Timeslots</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Location</th>
                                <th>Students</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($interviews as $interview)
                            <tr>
                                <td>{{$interview->formattedStartTime}}</td>
                                <td>{{$interview->formattedEndTime}}</td>
                                <td>{{$interview['location'] == '' ? 'TBA' : $interview['location']}}</td>
                                <td>{{$interview->applications}}</td>
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
