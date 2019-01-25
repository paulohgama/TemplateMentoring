@extends('site.layouts.master')

@section('meta-title', 'Acesso Restrito | Tarot Nova Era')
@section('meta-desc', '')

@section('content')
<section id="breadcrumb">
    <div class="container">
        <h1>Acesso Restrito</h1>
        <ul>
            <li>Você está em</li>
            <li><a href="/">Home</a></li>
            <li><a href="/login">Acesso Restrito</a></li>
        </ul>
    </div>
</section>

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-2">
                <div class="wrap">
                    <h2>Já possui cadastro?</h2>
                    <p>Entre para continuar e ter acesso a sua conta.</p>

                    @include('site.includes.msgs2')

                    <form action="{{url('login')}}" method="post" class="default">
                        @csrf
                        <div class="form-group">
                            <label for="emailuser">E-mail</label>
                            <input type="email" name="nm_login" id="emailuser" class="form-control" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="pwduser">Senha</label>
                            <input type="password" name="cd_senha" id="pwduser" class="form-control" value="" required>
                        </div>
                        <div class="forgot">
                            <p>Esqueceu sua senha? <a href="/recuperar-senha">Clique aqui</a></p>
                        </div>
                        <input type="hidden" value="1" name="telaComprar"/>
                        <div class="text-center">
                            <button type="submit">entrar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 mb-2">
                <div class="wrap">
                    <h2>Primeira Vez?</h2>
                    <p>Realize seu cadastro</p>

                      @include('site.includes.msgs')

                    <!-- for hide it when page is loaded use 'closed' class
                        like so: <div class="upfront-content closed">
                    -->

                <div class="upfront-content {{(Session::has('errors')?'closed':'')}}">
                        <h2>Primeira Vez?</h2>
                        <p>Realize seu cadastro</p>

                        <div class="text-center">
                            <a class="btn" data-close-upfront>cadastrar</a>
                        </div>
                    </div>

                <form action="{{url('cadastrar')}}" method="post" class="default">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" name="nm_visitante" id="nome" class="form-control" value="" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="emailcad">E-mail <span>(Será usado como login)</span></label>
                                    <input type="email" name="email" id="emailcad" class="form-control" value="" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwdcad">Senha</label>
                                    <input type="password" name="senha" id="pwdcad" class="form-control" value="" required>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="1" name="telaComprar"/>
                        <div class="text-center mt">
                            <button type="submit">cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    MainObj.events.closedRegisterTab();
</script>
@endsection
