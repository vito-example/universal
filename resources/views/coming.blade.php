<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Soon</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- <link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,600,400italic,700' rel='stylesheet' type='text/css'> -->
    <link href="https://fonts.googleapis.com/css?family=Space+Mono" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="{{ asset('coming_soon/css/animate.css')}}">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="{{ asset('coming_soon/css/icomoon.css')}}">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="{{ asset('coming_soon/css/bootstrap.css')}}">
    <!-- Theme style  -->
    <link rel="stylesheet" href="{{ asset('coming_soon/css/style.css')}}">

    <!-- Modernizr JS -->
    <script src="{{ asset('coming_soon/js/modernizr-2.6.2.min.js')}}"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
    <script src="{{ asset('coming_soon/js/respond.min.js')}}"></script>
    <![endif]-->

</head>
<body>

<div class="fh5co-loader"></div>

<div id="page">

    <div id="fh5co-container" class="js-fullheight">
        <div class="countdown-wrap js-fullheight">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="display-t js-fullheight">
                        <div class="display-tc animate-box">
                            <nav class="fh5co-nav" role="navigation">
                                <div id="fh5co-logo"><a href="">Soon<strong>.</strong></a></div>
                            </nav>
                            <h1>We Are Coming Soon!</h1>
                            <div class="simply-countdown simply-countdown-one"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-cover js-fullheight" style="background-image:url({{ asset('coming_soon/images/img_bg_1.jpg')}});">

        </div>
    </div>
</div>

<div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
</div>

<!-- jQuery -->
<script src="{{ asset('coming_soon/js/jquery.min.js')}}"></script>
<!-- jQuery Easing -->
<script src="{{ asset('coming_soon/js/jquery.easing.1.3.js')}}"></script>
<!-- Bootstrap -->
<script src="{{ asset('coming_soon/js/bootstrap.min.js')}}"></script>
<!-- Waypoints -->
<script src="{{ asset('coming_soon/js/jquery.waypoints.min.js')}}"></script>

<!-- Count Down -->
<script src="{{ asset('coming_soon/js/simplyCountdown.js')}}"></script>
<!-- Main -->
<script src="{{ asset('coming_soon/js/main.js')}}"></script>

<script>
    // default example
    simplyCountdown('.simply-countdown-one', {
        year: {{ now()->format('Y') }},
        month: 4,
        day: 27
    });

    //jQuery example
    $('#simply-countdown-losange').simplyCountdown({
        year: {{ now()->format('Y') }},
        month: 4,
        day: 27,
        enableUtc: false
    });
</script>

</body>
</html>

