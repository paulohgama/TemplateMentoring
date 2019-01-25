@extends('site.layouts.master')

@section('meta-title', 'Alterar Cadastro | Tarot Nova Era')
@section('meta-desc', '')

@section('content')
<section id="breadcrumb">
    <div class="container">
        <h1>Alterar Cadastro</h1>
        <ul>
            <li>Você está em</li>
            <li><a href="/">Home</a></li>
            <li><a href="">Alterar Cadastro</a></li>
        </ul>
    </div>
</section>

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="wrap">
                    <h2 class="mgt">Alterar Cadastro</h2>

                    @include('site.includes.msgs')

                <form action="{{route('visitante.atualizar', ['id' => $visitante[0]->cd_visitante]) }}" method="post" class="default">
                    @csrf
                        <input type="hidden" name="id_user" id="id_user" value="{{ $visitante[0]->cd_usuario }}">
                        <div class="divisor">
                            <h3 class="title">Dados Pessoais</h3>
                            <div class="form-group">
                                <label for="emailuser">Nome</label>
                                <div class="wrap-readonly">
                                <input type="text" name="nm_visitante" id="nome" class="form-control" value="{{ $visitante[0]->nm_visitante}}" readonly required>
                                    <i class="fa fa-pencil" aria-hidden="true" title="editar"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="emailuser">E-mail</label>
                                <div class="wrap-readonly">
                                <input type="email" name="email" id="emailuser" class="form-control" value="{{ $visitante[0]->email}}"  readonly required>
                                    <i class="fa fa-pencil" aria-hidden="true" title="editar"></i>
                                </div>
                            </div>
                            <input type="hidden" name="status" value="{{ $visitante[0]->status}}" readonly required>
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
