<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('painel-consultor.includes.head')
</head>
<body>

    <header id="consultor-header">
        <div class="wrap-content">
            <div class="logo-box">
                <a href="#" class="logo">
                    <img src="/images/logo-painel.png" alt="Logo" class="img-fluid">
                </a>
            </div>
            <div class="col pl-0 user-box">
                <div class="user-info">
                    <h5 class="name">Olá,
                        <?php
                            $nome = \App\Consultor::find(Auth::user()->cd_usuario_fk);
                            echo $nome->nm_consultor;
                        ?>
                    </h5>
                    <div class="user-photo">
                        <figure class="img-frame">
                            <img src="/images/especialistas/{{$nome->img_consultor}}">
                        </figure>
                    </div>
                </div>

                <div class="breadcrumb-wrapper">
                    @yield('breadcrumb')
                    <div class="link">
                        <a href="/">Voltar ao site</a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <div id="main-panel-wrap">
        @include('painel-consultor.includes.aside-nav')

        <!-- CONTENT -->
        <main id="main-box">
            <div class="container-fluid mt-4">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- This Global Component Listen For Notification -->

    <div id="global-notifier">
        <generic-consultant-notifier consultantid="{{Auth::user()->cd_usuario_fk}}"></generic-consultant-notifier>
    </div>

    <!-- WS URL && Socket Lib -->
    <script>window.WS_URL = "@php echo env('WS_URL', 'tarotnovaera.kinghost.net:21097'); @endphp"</script>
    <script src="{{ asset('js/socket.io.js') }}"></script>

    <script type="text/javascript" src="/vuejs/app.js"></script>

    <!-- SCRIPTS -->
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/jquery-mobile-events.min.js"></script>
    <script type="text/javascript" src="/js/vendor.js"></script>
    <script type="text/javascript" src="/js/maskedinput1.4.1.min.js"></script>
    <script type="text/javascript" src="/js/painel-consultor.min.js"></script>
    <link rel="stylesheet" href="{{ URL::asset('js/BootstrapMultiselect/dist/css/bootstrap-multiselect.css') }}" type="text/css">
    <script type="text/javascript" src="{{ URL::asset('js/BootstrapMultiselect/dist/js/bootstrap-multiselect.js') }}"></script>
    <script>
            $('#limparFiltroDataConsultorCredito').click(function(e)
            {
                e.preventDefault();
                window.location('{{route('credito.transferencia.index')}}', '_self');
            });
        </script>
    @yield('js')

</body>
</html>
