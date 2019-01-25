@extends('painel-consultor.layouts.clean')

@section('meta-title', 'Recuperar senha - Painel Consultor | Tarot Nova Era')
@section('meta-desc', '')

@section('meta-desc', '')

@section('content')
    <div class="container wrap-rounded-column mt-4 login-recovery wrap-60">
        <div class="wrap-login">
            <p>Informe seu e-mail para recuperar os dados de acesso.</p>
            @include('site.includes.recovery')
            <form action="{{url('/painel-consultor/recuperar-senha')}}" method="post" class="default">
                @csrf
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="teste@teste.com" class="form-control" required>
                </div>
                <div class="notification">Consulte sua caixa de SPAM caso não receba o email.</div>
                <button type="submit" class="mt-5">Enviar</button>
            </form>
        </div>
    </div>
@endsection