@extends('layouts.app')

@section('bottom_js')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.js"></script>
<script>
$(function() {
    $('#applications-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('datatables.data') !!}',
        columns: [
            { data: 'id', name: 'id', searchable: false},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'reviews', name: 'ratings',searchable: false},
            { data: 'UserRating', name: 'myrating',searchable: false},
            { data: 'avg', name: 'avg',searchable: false}
        ]
    });
});
</script>
@stop

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.css"/>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif        
            <div class="panel panel-default">
                <div class="panel-heading">All Applications</div>
                    <div class="panel-body">
                        <table class="table table-bordered" id="applications-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Ratings</th>
                                    <th>My Rating</th>
                                    @role('admin')
                                    <th>Average Rating</th>
                                    @endrole()
                                </tr>
                            </thead>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
