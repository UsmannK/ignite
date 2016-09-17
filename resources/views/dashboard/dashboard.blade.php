@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif        
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    @if(env('APP_PHASE') == 1)
                        @role(['admin', 'mentor'])
                            There are currently <b>{{$applications}}</b> applications.
                            <hr/>
                            You've rated {{$data['count']}} {{str_plural('application', $data['count'])}}, {{$applications-$data['count']}} to go!
                            <hr/>
                            Leaderboard:
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Name</th>
                                        <th>Ratings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 0; $i< count($users); $i++)
                                    	@if($users[$i]->ratings->count() < 50)
                                    		<tr class="danger">
                                    	@else
                                    		<tr>
                                    	@endif
                                        <th>{{$i+1}}</th>
                                        <th>{{$users[$i]->name}}</th>
                                        <th>{{$users[$i]->ratings->count()}}</th>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        @endrole
                    @elseif(env('APP_PHASE') == 2)
                        <h2 style="margin-top:0px;">Welcome back, <b>{{Auth::user()->name}}.</b></h2>
                        <hr/>
                        @if(!Auth::user()->image || !Auth::user()->about)
                            <div class="alert alert-danger">Please fill out <a href="{{action('PageController@showSettings')}}" class="alert-link">your description</a> and upload a <a href="{{action('PageController@showSettingsPicture')}}" class="alert-link">profile photo.</a></div>
                            <hr/>
                        @endif
                        There's nothing to see here...yet.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection