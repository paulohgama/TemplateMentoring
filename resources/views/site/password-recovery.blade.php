@extends('site.layouts.master')

@section('meta-title', 'Recuperar Senha | Tarot Nova Era')
@section('meta-desc', '')

@section('content')
<section id="breadcrumb">
    <div class="container">
        <h1>Recuperar Senha</h1>
        <ul>
            <li>Você está em</li>
            <li><a href="/">Home</a></li>
            <li><a href="/recuperar-senha">Recuperar Senha</a></li>
        </ul>
    </div>
</section>

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="wrap">
                    <h2>Recuperar Senha</h2>
                    <p>Informe seu e-mail para recuperar os seus dados de acesso.</p>

                    @include('site.includes.msgs')

                <form action="{{url('/visitante/recupera-senha')}}" method="post" class="default">
                        @csrf
                        <div class="form-group">
                            <label for="emailuser">E-mail</label>
                            <input type="email" name="email" id="emailuser" class="form-control" value="" required>
                        </div>
                        <div class="form-group">
                             <div class="notification text-right">Consulte sua caixa de SPAM caso não receba o e-mail.</div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit">enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
