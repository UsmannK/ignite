@extends('layouts.app')

@section('bottom_js')
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
    <script>
        var $container = $('.masonry-container');
        $container.imagesLoaded( function () {
            $container.masonry({
                columnWidth: '.item',
                itemSelector: '.item'
            });   
        });  
        $('a[data-toggle=tab]').each(function () {
            var $this = $(this);
            $this.on('shown.bs.tab', function () {
                $container.imagesLoaded( function () {
                    $container.masonry({
                        columnWidth: '.item',
                        itemSelector: '.item'
                    });   
                });  
            });
        });
        $(".readMore").click(function(){
            $("#infoModalLabel").html($(this).data('name'));
            $("#text").html($(this).data('description'));
            $("#image").attr('src', $(this).data('url'));
        });
</script>
@stop

@section('content')
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="infoModalLabel">title</h4>
      </div>
      <div class="modal-body" id="modal-body"> 
        <img id="image" src="" class="img-responsive" style="margin: 0 auto;">
        <hr/>
        <div id="text"></div>
        <hr/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Community Members</div>
                <div class="panel-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#mentors" aria-controls="mentors" role="tab" data-toggle="tab">Mentors</a></li>
                        <li role="presentation"><a href="#mentees" aria-controls="mentees" role="tab" data-toggle="tab">Mentees</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="mentors">
                            <br/>
                            <div class="row masonry-container">
                                @for($i = 0; $i < count($mentors); $i++)
                                    <div class="col-sm-6 col-md-4 item">
                                        <div class="thumbnail">
                                            @if($mentors[$i]['image'])
                                                <img src="{{asset('storage/' . $mentors[$i]['image'])}}">
                                            @else
                                                <img src="{{asset('SPA_assets/images/no-img.png')}}">
                                            @endif
                                            <div class="caption">
                                                <h3>{{$mentors[$i]['name']}}</h3>
                                                <p>{{$mentors[$i]['tagline']}}<p>
                                                <p><a href="#" class="btn btn-primary readMore" role="button" data-name="{{$mentors[$i]['name']}}" data-url="{{asset('storage/' . $mentors[$i]['image'])}}" data-description="{{$mentors[$i]['about']}}" data-toggle="modal" data-target="#infoModal">Read More</a></p>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="mentees">
                            <br/>
                            <div class="row masonry-container">
                                @for($i = 0; $i < count($mentees); $i++)
                                    <div class="col-sm-6 col-md-4 item">
                                        <div class="thumbnail">
                                            @if($mentees[$i]['image'])
                                                <img src="{{asset('storage/' . $mentees[$i]['image'])}}">
                                            @else
                                                <img src="{{asset('SPA_assets/images/no-img.png')}}">
                                            @endif
                                            <div class="caption">
                                                <h3>{{$mentees[$i]['name']}}</h3>
                                                <p>{{$mentees[$i]['tagline']}}<p>
                                                <p><a href="#" class="btn btn-primary readMore" role="button" data-name="{{$mentees[$i]['name']}}" data-url="{{asset('storage/' . $mentees[$i]['image'])}}" data-description="{{$mentees[$i]['about']}}" data-toggle="modal" data-target="#infoModal">Read More</a></p>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection