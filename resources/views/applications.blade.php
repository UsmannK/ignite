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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Ratings</th>
                                    <th>Average Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $app)
                                    <tr>
                                        <th><a href="{{action('PageController@showRate', ['id' => $app->id])}}">{{$app->id}}</a>
                                        <th>{{ $app->name }}</th>
                                        <th>{{ $app->getReviewsAttribute() }}</th>
                                        <th>{{ $app->ratingInfo()['average']}}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {{ $applications->links() }}
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
