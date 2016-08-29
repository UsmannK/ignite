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
        <header id="header">
            <h1 class="logo_menuBar hoverPointer"><a href="#banner">
                {!! file_get_contents(public_path()."/SPA_assets/images/logo/svg/ignite.svg") !!}</a>
            </h1>
            <nav id="nav">
                <ul>
                    <li class="hoverPointer"><a href="{{action('PageController@index')}}">Home</a></li>
                    <li class="hoverPointer"><a href="{{action('PageController@calendar')}}">Calendar</a></li>
                </ul>
            </nav>
        </header>
   
        <section id="main" class="mentorPage wrapper style1">
    <header class="major">
        <h2 class="redText">Calendar</h2>
    </header>
    <div class="container">
        <section id="content">
            <iframe src="https://www.google.com/calendar/embed?wkst=1&amp;bgcolor=%23FFFFFF&amp;src=iamffff8lb6mqh26t7fsdqduf8%40group.calendar.google.com&amp;color=%238C500B&amp;ctz=America%2FNew_York" style="border: 0; width: 100%; margin-left: auto; margin-right: auto; height: 700px;" frameborder="0" scrolling="no"></iframe>
        </section>
    </div>
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
         
            <!--[if lte IE 8]><script src="{{ asset('SPA_assets/js/ie/respond.min.js') }}"></script><![endif]-->
            <script src="{{ asset('SPA_assets/js/main.js') }}"></script>

    </body>
</html>