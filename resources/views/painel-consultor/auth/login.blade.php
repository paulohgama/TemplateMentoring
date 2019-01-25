@extends('painel-consultor.layouts.clean')

@section('meta-title', 'Login - Painel Consultor | Tarot Nova Era')
@section('meta-desc', '')

@section('meta-desc', '')

@section('content')
    <div class="container wrap-rounded-column mt-4 login-recovery wrap-60">
        @include('site.includes.msgs')
        <div class="wrap-login">
            <h2>Faça seu login</h2>
            <p>Realize seu login para ter acesso ao painel.</p>
            
        <form action="{{route('consultor.login')}}" method="post" class="default">
                @csrf
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="senha" class="form-control" required>
                </div>
                <div class="text-right fgpwd">Esqueceu sua senha? <a href="/painel-consultor/recuperar-senha">Clique aqui</a></div>
                <div class="text-center">
                    <button type="submit" class="mt-3">Entrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
