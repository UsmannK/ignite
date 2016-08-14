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
                                    <tr>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                    </tr>
                                </tbody>

                            </table>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
