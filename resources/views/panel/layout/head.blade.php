<head>
    @if(isset($setting->google_analytics_code))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$setting->google_analytics_code}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{$setting->google_analytics_code}}');
    </script>
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <!-- <link rel="icon" href="/{{$setting->favicon_path}}"> -->
    <title>{{$setting->site_name}} | @yield('title')</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@500;600;700&display=swap" rel="stylesheet">

    <link href="/assets/css/fonts.css" rel="stylesheet">
    <!-- CSS files -->
    <link href="/assets/css/tabler.min.css" rel="stylesheet"/>
    <link href="/assets/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="/assets/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="/assets/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="/assets/css/demo.min.css" rel="stylesheet"/>
    <link href="/assets/css/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Libs JS -->
<script src="/assets/libs/apexcharts/dist/apexcharts.min.js" defer></script>
<script src="/assets/libs/jsvectormap/dist/js/jsvectormap.min.js" defer></script>
<script src="/assets/libs/jsvectormap/dist/maps/world.js" defer></script>
<script src="/assets/libs/jsvectormap/dist/maps/world-merc.js" defer></script>
<!-- Tabler Core -->
<script src="/assets/js/tabler.min.js" defer></script>
<script src="/assets/js/opai.min.js" defer></script>

<!-- AJAX CALLS -->
<script src="/assets/openai/js/jquery.js"></script>
<script src="/assets/openai/js/main.js"></script>
<script src="/assets/openai/js/toastr.min.js"></script>
<script src="/assets/libs/tom-select/dist/js/tom-select.base.min.js?1674944402" defer></script>


<!-- PAGES JS-->
@guest()
<script src="/assets/js/panel/login_register.js"></script>
@endguest
<script src="/assets/js/panel/search.js"></script>

<script src="/assets/libs/list.js/dist/list.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    @yield('additional_css')
    <link href="/assets/css/magic-ai.css" rel="stylesheet"/>
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
	@vite('resources/css/app.css')
    @if($setting->dashboard_code_before_head != null)
        {!!$setting->dashboard_code_before_head!!}
    @endif


   
</head>
