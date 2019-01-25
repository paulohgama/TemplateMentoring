<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('painel-consultor.includes.head')   
</head>
<body>

    <header id="consultor-header" class="clean">
        <div class="wrap-content justify-content-center">
            <div class="logo-box">
                <a href="/" class="logo">
                    <img src="/images/logo-painel.png" alt="Logo" class="img-fluid">
                </a>
            </div>
        </div>
    </header>

    <!-- CONTENT -->        
    <div id="main-panel-wrap">
        @yield('content')
    </div>

    <!-- SCRIPTS --> 
    @yield('js')
    
</body>
</html>