@extends('layouts.app')

@section('bottom_js')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.js"></script>
<script>
$(function() {
    var table = $('#applications-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('datatables.data') !!}',
        columns: [
            { data: 'id', name: 'id', searchable: false},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'reviews', name: 'ratings',searchable: false},
            { data: 'UserRating', name: 'myrating',searchable: false},
            { data: 'interview_timeslot', name: 'interview_timeslot',searchable: false},
            { data: 'accepted', name: 'accepted',searchable: false},
            {
                "className":'interview',
                "orderable":      false,
                "searchable":      false,
                "data":           null,
                "defaultContent": 'Interview &raquo;'
            },
            @role('admin')
            { data: 'avg', name: 'avg',searchable: false},
            { data: 'interview_avg', name: 'interview_avg',searchable: false},
            { data: 'total_avg', name: 'total_avg',searchable: false}
            @endrole()
        ],
        "aoColumnDefs": [
            {
                "aTargets": [0], // Column to target
                "mRender": function ( data, type, full ) {
                    return '<a href="{{action('PageController@showRate')}}/' + data + '">' + data + '</a>';
                }
            },
            {
                "aTargets": [7], // Column to target
                "mRender": function ( data, type, full ) {
                    return '<a href="{{action('PageController@showInterview')}}/' + full['id'] + '">Interview &raquo;</a>';
                }             
            },
            {
                "aTargets": [5], // Column to target
                "mRender": function ( data, type, full ) {
                    console.log(data);
                    if(data)
                        return '&#9989;'
                    return '&#10006'
                }             
            },
            {
                "aTargets": [6], // Column to target
                "mRender": function ( data, type, full ) {
                    console.log(data);
                    if(data == 1)
                        return 'Accepted'
                    else if(data == -1)
                        return 'Standby'
                    else if(data == 0)
                        return 'Rejected'
                }             
            }
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
                                    <th>Scheduled?</th>
                                    <th>Status</th>
                                    <th>Interview</th>
                                    @role('admin')
                                    <th>Average Rating</th>
                                    <th>Interview</th>
                                    <th>Total</th>
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
