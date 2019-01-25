<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('site.includes.head')
</head>
<body>
    <!-- NAV -->
    @include('site.includes.nav')

    <!-- CONTENT -->
    <div id="vue-app">
        @yield('content')
    </div>

    <!-- FOOTER -->
    @include('site.includes.footer')

    @if(Auth::user() && Auth::user()->cd_role == 2)
    <!-- This Global Component Listen For Notification -->
    <div id="global-notifier">
        <generic-consultant-notifier consultantid="{{\App\Consultor::find(Auth::user()->cd_usuario_fk)->cd_consultor}}"></generic-consultant-notifier>
    </div>
    @else
    <div id="global-notifier"></div>
    @endif

    <!-- WS URL && Socket Lib -->
    <script>window.WS_URL = "@php echo env('WS_URL', 'tarotnovaera.kinghost.net:21097/'); @endphp"</script>
    <script src="{{ asset('js/socket.io.js') }}"></script>


    <!-- VUEJS -->
    <script type="text/javascript" src="/vuejs/app.js"></script>

    <!-- SCRIPTS -->
    <script type="text/javascript" src="/js/vendor.js"></script>
    <script type="text/javascript" src="/js/maskedinput1.4.1.min.js"></script>
    <script type="text/javascript" src="/js/main.min.js"></script>

    @yield('js')

</body>
</html>
