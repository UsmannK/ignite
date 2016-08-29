<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <title>Ignite</title>
        <meta charset="utf-8" />
        <meta name="description" content="Ignite connects talented upperclassmen at Purdue University with motivated freshmen, who we know will shape the future." />
        <meta name="keywords" content="Ignite, Purdue, Computer, Science, Ignite The Flame, ignitetheflame, Purdue Hackers, Hackers, Boilermake, Mentorship, Mentor, Mentee" />
        <meta property="og:image" content="{{ asset('SPA_assets/images/logo/logo_square.png') }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!--[if lte IE 8]><script src="{{ asset('SPA_assets/js/ie/html5shiv.js') }}"></script><![endif]-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('SPA_assets/css/main.css?ver=1') }}" />
        <!--[if lte IE 8]><link rel="stylesheet" href="{{ asset('SPA_assets/css/ie8.css') }}" /><![endif]-->
        <!--[if lte IE 9]><link rel="stylesheet" href="{{ asset('SPA_assets/css/ie9.css') }}" /><![endif]-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> {{-- jQuery UI CSS --}}
        <link rel="stylesheet" href="{{ asset('SPA_assets/css/ignite.css?ver=1') }}" />
        <link rel="stylesheet" href="{{ asset('SPA_assets/css/modal.min.css') }}" />
    </head>
    <body {!! Route::currentRouteAction()=="App\Http\Controllers\PageController@index"?'class="landing"':'' !!}>
        <header id="header" class="alt">
            <h1 class="logo_menuBar hoverPointer" onclick='scrollTo("#banner");'>
                {!! file_get_contents(public_path()."/SPA_assets/images/logo/svg/ignite.svg") !!}
            </h1>
            <nav id="nav">
                <ul>
                    <li class="hoverPointer"><a href="#why" onclick='scrollTo("#why");'>Why</a></li>
                    <li class="hoverPointer"><a href="#mentors" onclick='scrollTo("#mentors");'>Mentors</a></li>
                    <li class="hoverPointer"><a href="#cta" onclick='scrollTo("#cta");'>Contact</a></li>
                    <li class="hoverPointer"><a href="{{action('PageController@calendar')}}">Calendar</a></li>
                </ul>
            </nav>
        </header>
       
             <!-- Banner -->
<section id="banner">
    <div class="inner">
        <h2 class="banner_flame">{!! file_get_contents(public_path()."/SPA_assets/images/logo/svg/flame.svg") !!}</h2>
        <h2 class="banner_ignite">{!! file_get_contents(public_path()."/SPA_assets/images/logo/svg/ignite.svg") !!}</h2>
        <p>Our mission is to ignite a generation of talented and ambitious students at Purdue.<br>Join us Fall 2016.</p>
        <form action="https://ignitetheflame.typeform.com/to/BfyMt9" method="get" name="applyButton" class="row uniform banner_actions" target="_blank" novalidate="">
            <div class="12u"><input type="submit" value="Apply"></div>
        </form>
    </div>
        <a href="#" class="nextPage" onclick='scrollTo("#why");'>
            <i class="fa fa-angle-down fa-3x"></i>
        </a>
</section>

<!-- About -->
<section id="why" class="wrapper style2">
    <div class="container">
        <header class="major">
            <h2>
                <i class="fa fa-bolt fa-3x bigIcon trippy"></i><br>
                Why Ignite?
            </h2>
            <p>
                We saw a gap. A gap between the students who build products, start companies, and get <span class="redText">kick-ass</span> internships and the students who don't even know where to begin. Our goal is to close that gap, giving more students an opportunity to do awesome things, and to <span class="redText">ignite</span> a movement.<br>
                <br>
                Ignite connects <span class="redText">talented</span> upperclassmen with <span class="redText">motivated</span> freshmen, who we know will shape the future.
            </p>
        </header>
    </div>
    <div class="container"><br><br><hr><br><br></div>
    <div class="container">
        <div class="row uniform">
            <div class="4u 6u(medium) 12u$(small)">
                <section class="feature fa-code">
                    <h3>Code</h3>
                    <p>Code is the differentiating factor between someone with an idea and someone with a product. We'll help you get started from the ground up.</p>
                </section>
            </div>
            <div class="4u 6u$(medium) 12u$(small)">
                <section class="feature fa-cogs">
                    <h3>Build</h3>
                    <p>The hardest part of building something is finding out where to begin. Not only will we help you get started but we'll push you to finish it.</p>
                </section>
            </div>
            <div class="4u$ 6u(medium) 12u$(small)">
                <section class="feature fa-graduation-cap">
                    <h3>Learn</h3>
                    <p>College is a great place to learn, both in and out of the classroom. Your mentor will be there to answer any questions you may have.</p>
                </section>
            </div>
            <div class="4u 6u$(medium) 12u$(small)">
                <section class="feature fa-users">
                    <h3>Connect</h3>
                    <p>Your network is one of your most valuable assets, let us expand it ten-fold.</p>
                </section>
            </div>
            <div class="4u 6u(medium) 12u$(small)">
                <section class="feature fa-clock-o">
                    <h3>Attend</h3>
                    <p>You and your mentor will meet weekly, and we'll have program events every three weeks for you to connect with other participants.</p>
                </section>
            </div>
            <div class="4u$ 6u$(medium) 12u$(small)">
                <section class="feature fa-trophy">
                    <h3>Succeed</h3>
                    <p>Ignite will jumpstart your life. Our goal is to open as many doors for you as possible, all you need to do is walk through them.</p>
                </section>
            </div>
        </div>
    </div>
    <br><br>
</section>

<!-- Mentors -->
<section id="mentors" class="wrapper style1">
    <div class="container">
        <header class="major">
            <h2>Meet Our Mentors</h2>
            <hr>
        </header>
        <div class="row">
            <?php $count = 0; ?>
            @foreach($mentors as $mentor)
                <?php $count++; ?>
                @if($mentor['image'])
                <div class="3u{{ $count%4==0?'$':'' }} 4u{{ $count%3==0?'$':'' }}(medium) 12u$(small)" data-name="{{$mentor['name']}}" data-url="{{asset('storage/' . $mentor['image'])}}" data-about="{{$mentor['about']}}">
                @else
                <div class="3u{{ $count%4==0?'$':'' }} 4u{{ $count%3==0?'$':'' }}(medium) 12u$(small)" data-name="{{$mentor['name']}}" data-url="{{asset('SPA_assets/images/no-img.png')}}" data-about="{{$mentor['about']}}">
                @endif
                    <article class="box post">
                        <a href="" class="modal_trigger">
                            @if($mentor['image'])
                                <img src="{{asset('storage/' . $mentor['image'])}}" class="image fit" />
                            @else
                                <img src="{{asset('SPA_assets/images/no-img.png')}}" class="image fit" />
                            @endif
                        </a>
                        <h3 class="redText"><a href="" class="modal_trigger">{{$mentor['name']}}</a></h3>
                        <p>{{$mentor['tagline']}}</p>
                        <ul class="icons mentorIcons">
                            @if($mentor['fb'] != "")
                                <li><a href="http://www.facebook.com/{{ $mentor['fb'] }}" class="icon fa-facebook" target="_blank"><span class="label">Facebook</span></a></li>
                            @endif
                            @if($mentor['github'] != "")
                                <li><a href="http://www.github.com/{{ $mentor['github'] }}" class="icon fa-github" target="_blank"><span class="label">Github</span></a></li>
                            @endif
                            @if($mentor['website'] != "")
                                <li><a href="{{ $mentor['website'] }}" class="icon fa-desktop" target="_blank"><span class="label">Website</span></a></li>
                            @endif
                        </ul>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Questions -->
<section id="cta" class="wrapper style3">
    <h2>Questions?</h2>
    <ul class="actions">
        <li><a href="mailto:contact@ignitethefla.me?subject=I've got a question about Ignite!&body=I've got a question about Ignite!1%0D%0A%0D%0A" class="button big">Email Us</a></li>
    </ul>
</section>
<div class="ui modal" id="modal">
  <i class="close icon"></i>
  <div class="header" id="mentorName"></div>
    <div class="image fit" id="mentorImage" style="max-width: 300px;margin:0 auto;margin-top:20px;"></div>
        <hr/>
    <div class="description" id="mentorAbout" style="padding:20px;"></div>
  <div class="actions">
    <div class="ui positive button">
      Close
    </div>
  </div>
</div>
        <!-- Footer -->
            <footer id="footer">
                <ul class="icons">
                    <li><a href="https://twitter.com/ignitepurdue" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                    <li><a href="https://www.facebook.com/ignitepurdue" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="mailto:contact@ignitethefla.me" class="icon fa-envelope"><span class="label">Email</span></a></li>
                </ul>
                <span class="copyright">
                    &copy; <a href="http://www.purduehackers.com" target="_blank">Purdue Hackers</a>. All rights reserved.
                </span>
            </footer>

        <!-- Scripts -->
            <script src="{{ asset('SPA_assets/js/jquery.min.js') }}"></script>
            <script src="{{ asset('SPA_assets/js/modal.min.js') }}"></script>
            <script>
            $(document).ready(function(){
                $(".modal_trigger").click(function(e){
                    var div = $(this).closest('div');
                    $("#mentorName").html(div.data('name'));
                    $("#mentorImage").html("<img src='"+div.data('url')+"'>");
                    $("#mentorAbout").html(div.data('about'));
                    console.log(div.data('tagline'));
                    $('.ui.modal').modal('show');
                    e.preventDefault();
                });
            });
            </script>
            <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> {{-- jQuery UI --}}
            {{--<script src="{{ asset('SPA_assets/js/jquery.dropotron.min.js') }}"></script>--}}
            <script src="{{ asset('SPA_assets/js/jquery.scrollgress.min.js') }}"></script>
            <script src="{{ asset('SPA_assets/js/jquery.scrolly.min.js') }}"></script>
            {{--<script src="{{ asset('SPA_assets/js/jquery.slidertron.min.js') }}"></script>--}}
            <script src="{{ asset('SPA_assets/js/skel.min.js') }}"></script>
            <script src="{{ asset('SPA_assets/js/util.js') }}"></script>
            <script>
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
              (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

              ga('create', 'UA-17806840-31', 'auto');
              ga('send', 'pageview');

            </script>
            <!--[if lte IE 8]><script src="{{ asset('SPA_assets/js/ie/respond.min.js') }}"></script><![endif]-->
            <script src="{{ asset('SPA_assets/js/main.js') }}"></script>

    </body>
</html>