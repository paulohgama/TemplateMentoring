@extends('site.layouts.master')

@section('meta-title', 'Consultores | Tarot Nova Era')
@section('meta-desc', '')

@section('content')
<meta property="og:url"                content="{{url('/consultores/show/'.$consultores->cd_consultor)}}" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="Venha se consultar no Tarot Nova Era" />
<meta property="og:description"        content="Venha se consultar com o consultor {{$consultores->nm_consultor}} no site Tarot Nova Era" />
<meta property="og:image"              content="{{url('/images/especialistas/'.$consultores->img_consultor)}}" />
<section id="breadcrumb">
    <div class="container">
        <h1>Consultores</h1>
        <ul>
            <li>Você está em</li>
            <li><a href="/">Home</a></li>
            <li><a href="/consultores">Consultores</a></li>
        </ul>
    </div>
</section>
<section id="consultants-show">
    <!-- Perfil -->
    <consultant-detail-status :consultor="{{ $consultores }}" :statusclass="{{ $ocupado }}" idcomponente="{{($ocupado=='true') ? 'ocupado' : (intval($visitante['qt_segundos']) <= 0 ? 'creditoInsuficiente' : (intval(Auth::user()->cd_role) == 2 ? 'consultor' : '' ))}}">
        <template slot="slot1">
                <div class="title-wrapping">
                    <div>
                        <h2>{{$consultores->nm_consultor}}</h2>
                        <?php $count = count($especialidades); ?>
                        <p>@if($count > 0)
                            <?php $i = 0; ?>
                            @foreach($especialidades as $item)
                                @if ($i == $count-2)
                                    {{$item->nm_especialidade.' e'}}
                                @elseif($i == $count-1)
                                    {{$item->nm_especialidade}}
                                @else
                                    {{$item->nm_especialidade.', '}}
                                @endif
                                <?php $i++; ?>
                            @endforeach
                        @endif</p>
                    </div>
                    <a class="btn" href="/chat-visitante/{{$consultores->cd_consultor}}" {{($ocupado=='true') ? 'id=ocupado' : (intval($visitante['qt_segundos']) <= 0 ? 'id=creditoInsuficiente' : (intval(Auth::user()->cd_role) == 2 ? 'id=consultor' : '' ))}}><div class="spriting"></div>chamar</a>
                </div>
                <div class="editor-info"><?php echo $consultores->ds_consultor ?>
                </div>
          
        </template>
    </consultant-detail-status>

    @if(count($depoimentos) > 0)
    <div class="evaluation-content">
        <div class="container">
            <h2>O que eles dizem?</h2>
            <ul class="rate-list">
                @foreach($depoimentos as $d)
                <li>
                    <div class="wrap-rating">
                        <select class="rating" data-rating="{{$d->nt_depoimento}}">
                            <option value="1" {{($d->nt_depoimento >= 1)? 'Selected' : '' }}>1</option>
                            <option value="2" {{($d->nt_depoimento >= 2)? 'Selected' : '' }}>2</option>
                            <option value="3" {{($d->nt_depoimento >= 3)? 'Selected' : '' }}>3</option>
                            <option value="4" {{($d->nt_depoimento >= 4)? 'Selected' : '' }}>4</option>
                            <option value="5" {{($d->nt_depoimento >= 5)? 'Selected' : '' }}>5</option>
                        </select>
                    </div>

                    <div class="title-wrap">
                        <h3>{{$d->nm_visitante}}</h3>
                        <span class="date">{{date('d/m/Y', strtotime($d->dt_depoimento))}}</span>
                    </div>

                    <p>
                    <?= nl2br($d->ds_depoimento) ?>
                    </p>
                </li>
                @endforeach
            </ul>

            <!-- Pagination -->
            <div id="paginator">
                {{$depoimentos->links('painel-consultor.paginacao')}}
            </div>
        </div>
    </div>
    @endif
</section>
@endsection

@section('js')

<script>
    MainObj.events.ratingstar();
</script>
@endsection
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function(){
    $('#ocupado').click(function(){
        event.preventDefault()
    });
    $('#creditoInsuficiente').click(function()
    {
        event.preventDefault();
        window.location = '/comprar-minutos';
    });
    $('#consultor').click(function()
    {
        event.preventDefault();
        alert('Consultores não podem chamar consultores');
    });
});
</script>
