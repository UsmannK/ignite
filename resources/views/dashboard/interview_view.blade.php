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
                    <div class="alert alert-info">All interviews will be held in the <a href="https://goo.gl/maps/eYPYZfxWNAo">Anvil</a>. Please try to arrive to your assigned timeslot at least five minutes ahead of time. If you have interviews scheduled back to back, make sure to keep an eye on the clock.<hr/><a href="https://docs.google.com/document/d/12iQzIme9IrPk7c9MmjmuYEkBbdLBUSObiIOlw27cSmM/edit?usp=sharing">View Interview Questions &raquo;</a></div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="hidden-xs hidden-sm hidden-md">ID</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Students</th>
                                <th style="min-width:100px;">Interview</th>
                                <th>Mentors</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($interviews as $interview)
                            <tr>   
                                <td class="hidden-xs hidden-sm hidden-md">#{{$interview->id}}</td>
                                <td>{{$interview->formattedStartTime}}</td>
                                <td>{{$interview->formattedEndTime}}</td>
                                <td>{{$interview->applications}}</td>
                                @if($interview->applicationsID == '')
                                <td>-</td>
                                @else
                                <td><a href="{{action('PageController@showInterview')}}{{$interview->applicationsID}}">Interview &raquo;</a></td>
                                @endif
                                <td>
                                    @foreach($interview->mentorsAssigned as $mentor)
                                       {{$mentor['mentor']['name']}},
                                    @endforeach
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
