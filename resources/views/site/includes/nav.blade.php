<nav id="main-nav">
    <div class="top-line">
        <div class="container">
            <div class="row">
                <div class="offset-lg-3 offset-md-2 col-lg-2 col-md-1">
                    <a href="https://api.whatsapp.com/send?phone=5500000000000&text=Olá%20Tarot%20Nova%20Era" target="_blank" class="whats"><span class="spriting sprite-whats"></span> (00) 0000 -
                        0000
                    </a>
                </div>

                @if(!Auth::check())
                <div class="col-lg-5 col-md-6">
                    <form action="{{url('login')}}" class="form-login" method="Post">
                        @csrf
                        <div class="wrap-input mr-1">
                            <span class="spriting centerY sprite-user1"></span>
                            <input type="text" name="nm_login" placeholder="Login" required>
                        </div>
                        <div class="wrap-input">
                            <span class="spriting centerY sprite-key1"></span>
                            <input type="password" name="cd_senha" placeholder="Senha" required>
                        </div>
                        <button type="submit">ok</button>
                        <a href="/login" class="pwd-forget">Esqueceu sua senha?</a>
                    </form>
                </div>
                <div class="col-lg-2 col-md-3 text-right">
                    <a href="/login" class="register-link"><span class="spriting centerY sprite-user"></span>
                        cadastro
                    </a>
                </div>
                @else
                    @if (Auth::user()->cd_role == 3)
                        <div class="col justify-content-between d-flex">
                            <div class="total-minutes">
                                <span class="spriting sprite-clock"></span>
                                <h6>Minutos/Disponíveis</h6>
                                <span class="total">
                                    @php
                                        $min = \App\Visitante::find(Auth::user()->cd_usuario_fk);
                                        $minutos = $min->qt_segundos % 3600;
                                        $horas = ($min->qt_segundos - $minutos) / 3600;
                                        $segundos = $minutos % 60;
                                        $minutos = ($minutos - $segundos) / 60;
                                        if($horas < 10)
                                        {
                                            $horas = "0" . $horas;
                                        }
                                        if($segundos < 10)
                                        {
                                            $segundos = "0" . $segundos;
                                        }
                                        if($minutos < 10)
                                        {
                                            $minutos = "0" . $minutos;
                                        }
                                        echo $horas.":".$minutos.":".$segundos;
                                    @endphp
                                </span>
                                <a href="/comprar-minutos" class="btn">Comprar Minutos</a>
                            </div>
                            <div class="box-user">
                                <span class="name">Olá, @php
                                     $nome = \App\Visitante::find(Auth::user()->cd_usuario_fk);
                                         echo $nome->nm_visitante;
                                @endphp</span>
                                <a class="login-menu" data-btn-logged><span class="spriting sprite-menu"></span></a>
                                <ul class="tiny-menu">
                                <li><a href="{{ route('visitante.alterar', ['id' => $nome->cd_visitante]) }}">Meus Dados</a></li>
                                <li><a href="/visitante/minha-conta/alterar-senha">Alterar senha</a></li>
                                    <li>
                                        <form action="{{route('logout')}}" id="flogout" method="Post">
                                            @csrf
                                            <a href="javascript:{}" onclick="document.getElementById('flogout').submit(); return false;">Logout</a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @elseif(Auth::user()->cd_role == 2)
                        <div class="col justify-content-between consultor-menu d-flex">
                            <div class="box-user">
                                <span class="name">Olá, @php
                                    $nome = \App\Consultor::find(Auth::user()->cd_usuario_fk);
                                        echo $nome->nm_consultor;
                                @endphp</span>
                                <a class="login-menu" data-btn-logged><span class="spriting sprite-menu"></span></a>
                                <ul class="tiny-menu">
                                    {{-- <li><a href="">Meus Dados</a></li> --}}
                                    <li>
                                        <form action="{{route('logout')}}" id="flogout" method="Post">
                                            @csrf
                                            <a href="javascript:{}" onclick="document.getElementById('flogout').submit(); return false;">Logout</a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @elseif(Auth::user()->cd_role == 1)
                        <div class="col justify-content-between d-flex">
                            <div class="box-user">
                                <span class="name">Olá, admin @php
                                    // $nome = \App\Administrador::find(Auth::user()->cd_usuario_fk);
                                    //     echo $nome->nm_admin;
                                @endphp</span>
                                <a class="login-menu" data-btn-logged><span class="spriting sprite-menu"></span></a>
                                <ul class="tiny-menu">
                                    <li>
                                        <form action="{{route('logout')}}" id="flogout" method="Post">
                                            @csrf
                                            <a href="javascript:{}" onclick="document.getElementById('flogout').submit(); return false;">Logout</a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="main-part w-100 navbar-expand-md">
        <div class="container">
            <div class="row">
                <div class="col-md-3 logo-box">
                    <a href="/" class="logo">
                        <img src="/images/logo.png" class="img-fluid" alt="Logo Tarot Nova Era">

                    </a>
                    <a href="/" class="logo-mobile">
                        <img src="/images/logo-mobile.png" class="img-fluid" alt="Logo Tarot Nova Era">
                    </a>

                    <button class="navbar-toggler" data-toggle="collapse" data-target="#navigationComponent">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <div class="col-md-9">
                    <div class="collapse navbar-collapse" id="navigationComponent">
                        <ul class="navbar-nav">
                            <li class="nav-item is-sm">
                                <a class="nav-link" href="/login">Cadastro</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/consultores">Consultores</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/comprar-minutos">Comprar Minutos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/#how-it-works">Como Funciona</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/contato">Contato</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</nav>
