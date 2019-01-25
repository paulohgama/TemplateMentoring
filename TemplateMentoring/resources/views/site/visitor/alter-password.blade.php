@extends('site.layouts.master')

@section('meta-title', 'Alterar Cadastro | Tarot Nova Era')
@section('meta-desc', '')

@section('content')
<section id="breadcrumb">
    <div class="container">
        <h1>Alterar Senha</h1>
        <ul>
            <li>Você está em</li>
            <li><a href="/">Home</a></li>
            <li><a href="/visitante/minha-conta/alterar-senha">Alterar Senha</a></li>
        </ul>
    </div>
</section>

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="wrap">
                    <h2 class="mgt">Alterar Senha</h2>

                    @include('site.includes.msgs')

                <form action="{{route('altera.senha')}}" method="post" class="default">
                    @csrf
                        <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->cd_usuario }}">
                        <div class="divisor">
                            <div class="form-group">
                                <label for="senha_atual">Senha atual</label>
                                <input type="password" name="senha_atual" id="senhaatual" class="form-control" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="nova_senha">Nova senha</label>
                                <input type="password" name="nova_senha" id="novasenha" class="form-control" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="nova_senha_confirmation">Confirmar nova senha</label>
                                <input type="password" name="nova_senha_confirmation" id="cnovasenha" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit">Alterar</button>
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
    MainObj.events.disableReadOnly();
</script>
@endsection
