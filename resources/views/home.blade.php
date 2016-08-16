<!DOCTYPE HTML> {{-- Add Calendar --}}
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
        
        <!-- Google Analytics -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            
            ga('create', 'UA-15660382-9', 'auto');
            ga('send', 'pageview');
        </script>
    </head>
    <body {!! Route::currentRouteAction()=="App\Http\Controllers\PageController@index"?'class="landing"':'' !!}>

        <!-- Header -->
        @if(Route::currentRouteAction()=="App\Http\Controllers\PageController@index")
            <header id="header" class="alt">
                <h1 class="logo_menuBar hoverPointer" onclick='scrollTo("#banner");'>
                    {!! file_get_contents(public_path()."/SPA_assets/images/logo/svg/ignite.svg") !!}
                </h1>

                <nav id="nav">
                    <ul>
                        <li class="hoverPointer"><a href="#why" onclick='scrollTo("#why");'>Why</a></li>
                        <li class="hoverPointer"><a href="#mentors" onclick='scrollTo("#mentors");'>Mentors</a></li>
                        <li class="hoverPointer"><a href="#cta" onclick='scrollTo("#cta");'>Contact</a></li>
          
                        @if(session('loggedIn') == "true")
                            <li class="hoverPointer"><a href="{{ action('PageController@dashboard') }}">Interviews</a></li>
                        @endif
                    </ul>
                </nav>
            </header>
        @else
            <header id="header">
                <h1 class="logo_menuBar hoverPointer"><a href="{{ action('IgniteController@getIndex') }}#banner">
                    {!! file_get_contents(public_path()."/SPA_assets/images/logo/svg/ignite.svg") !!}</a>
                </h1>

                <nav id="nav">
                    <ul>
                        <li class="hoverPointer"><a href="#why">Why</a></li>
                        <li class="hoverPointer"><a href="#mentors">Mentors</a></li>
                        <li class="hoverPointer"><a href="#cta">Contact</a></li>

                        @if(session('loggedIn') == "true")
                            <li class="hoverPointer"><a href="{{ action('IgniteController@getInterviews') }}">Interviews</a></li>
                            <li class="hoverPointer"><a href="{{ action('IgniteController@getApplications') }}">Applications</a></li>
                            <li class="hoverPointer"><a href="{{ action('IgniteController@getLogout') }}">Logout</a></li>
                        @endif
                    </ul>
                </nav>
            </header>
        @endif

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
            <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> {{-- jQuery UI --}}
            {{--<script src="{{ asset('SPA_assets/js/jquery.dropotron.min.js') }}"></script>--}}
            <script src="{{ asset('SPA_assets/js/jquery.scrollgress.min.js') }}"></script>
            <script src="{{ asset('SPA_assets/js/jquery.scrolly.min.js') }}"></script>
            {{--<script src="{{ asset('SPA_assets/js/jquery.slidertron.min.js') }}"></script>--}}
            <script src="{{ asset('SPA_assets/js/skel.min.js') }}"></script>
            <script src="{{ asset('SPA_assets/js/util.js') }}"></script>
            <!--[if lte IE 8]><script src="{{ asset('SPA_assets/js/ie/respond.min.js') }}"></script><![endif]-->
            <script src="{{ asset('SPA_assets/js/main.js') }}"></script>

    </body>
</html>