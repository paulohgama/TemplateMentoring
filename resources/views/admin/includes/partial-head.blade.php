<title>@yield('title') - {{ config('app.name') }}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Cache-Control: max-age=3600, must-revalidate" />
<meta name="theme-color" content="#f37021" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="mobile-web-app-capable" content="yes">
<link rel="icon" type="image/png" href="{{ url('/images/favicon-96x96.png') }}" sizes="96x96" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="#f37021">
<meta name="apple-mobile-web-app-title" content="Painel Admin - {{ config('app.name') }}">
<link rel="icon" type="image/png" href="{{ url('/images/favicon-96x96.png') }}" sizes="96x96" />
<link rel="icon" type="image/png" href="{{ url('/images/favicon-32x32.png') }}" sizes="32x32" />
<link rel="icon" type="image/png" href="{{ url('/images/favicon-16x16.png') }}" sizes="16x16" /> {{--
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
    crossorigin="anonymous"> --}}
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
    crossorigin="anonymous"> {{--
<link rel="stylesheet" href="{{ url('/css/fontello/css/fontawesome-webfont.css') }}" /> --}}
<!-- <link rel="stylesheet" href="//cdn.jsdelivr.net/alertifyjs/1.9.0/css/themes/bootstrap.rtl.min.css" /> -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/blitzer/jquery-ui.min.css" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/alertifyjs/1.9.0/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.16/jquery.datetimepicker.min.css">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="{{ url('/css/admin/main.min.css') }}" type="text/css" />
<meta name="google-signin-client_id" content="376017440635-76gaq1a1dmpp6ab18d2k7asrti32eoe8.apps.googleusercontent.com">
<meta name="google-signin-scope" content="https://www.googleapis.com/auth/analytics.readonly"> @yield('css')
