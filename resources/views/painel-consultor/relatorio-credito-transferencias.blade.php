@extends('painel-consultor.layouts.master')

@section('meta-title', 'Relatório Créditos e Transferências - Painel Consultor | Tarot Nova Era')
@section('meta-desc', '')

@section('meta-desc', '')

@section('breadcrumb')
<ul class="breadcrumb-list">
    <li>Você está em</li>
    <li>Home</li>
    <li>Creditos Transferências</li>
    <li>Relatório</li>
</ul>
@endsection

@section('content')
<section id="credito-transferencias">

    <div class="full-credit">
        <h4>Seus Créditos</h4>
        <h2 class="mb-0">{{ 'R$ '.number_format($consultor['qt_creditos'], 2, ',', '.')}}</h2>
    </div>
    <div class="search-date-box">
        <div class="wrap-search">
            <form action="" method="get">
                <label for="inicio">Buscar por data</label>
                <div class="wrap-input">
                    <input type="text" id="data-inicio" name="inicio" placeholder="Início" required>
                    <div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
                <div class="wrap-input">
                    <input type="text" id="data-fim" name="fim" placeholder="Fim" required>
                    <div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
                <button type="submit">Filtrar</button>
                <a class="filtroRemover" href="{{route('credito.transferencia.index')}}"> limpar filtro</a>
            </form>
        </div>
    </div>
    <div class="wrap-rounded-column pt-0 pl-0 pr-0 mb-5">
        <!-- table listing -->
        <div id="table-block">
            <div class="container-fluid p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>Motivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dados as $item)
                            <tr>
                                <td>
                                    <span class="{{$item['tipo'] == 2 ? 'tarja red' : 'tarja green'}}">{{ ($item['tipo'] == 2 ? '- ' : '+ ').'R$ '.number_format($item['valor'], 2, ',', '.')}}</span>
                                </td>
                                <td>{{$item['data']}}</td>
                                <td>{{$item['motivo']}}</td>
                            </tr>
                            @endforeach
                            @if(count($dados) == 0 && app('request')->has('inicio'))
                            <tr>
                                    <td style="text-align: center" colspan="3">
                                        <i> Nenhuma movimentação de credito neste perido </i>
                                    </td>
                            </tr>
                            @elseif(count($dados) == 0)
                            <tr>
                                    <td style="text-align: center" colspan="3">
                                        <i> Nenhuma movimentação de credito </i>
                                    </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div id="paginator" class="mt-5">
                    <ul>
                        @php
                            if(app('request')->get('inicio'))
                            {
                                $mantem = "?".Request::getQueryString()."&";
                            }
                            else {
                                $mantem = '?';
                            }
                        @endphp
                        @if(app('request')->has('page'))
                            <li class="prev {{intval(app('request')->get('page')) == 1 ? "disabled" : "" }}"><a href="{{route('credito.transferencia.index').$mantem.'page='.(intval(app('request')->get('page'))-1)}}">Anterior</a></li>
                            @for($i = 1; $i <= intval($tamanho/10)+1; $i++)
                                <li class="{{intval(app('request')->get('page')) == $i ? "active" : ""}}"><a href="{{route('credito.transferencia.index').$mantem.'page='.$i}}">{{$i}}</a></li>
                            @endfor
                            <li class="next {{($tamanho < 10) ? 'disabled' : ''}}"><a href="{{ ($tamanho > (intval(app('request')->get('page'))*10)) ? route('credito.transferencia.index').$mantem.'page='.(intval($tamanho/10)+1) : "#"}}">Próximo</a></li>
                        @else
                            <li class="prev disabled"><a href="">Anterior</a></li>
                            <li class="active"><a href="#">1</a></li>
                            @for($i = 2; $i <= intval($tamanho/10)+1; $i++)
                                <li><a href="{{route('credito.transferencia.index').$mantem.'page='.$i}}">{{$i}}</a></li>
                            @endfor
                            <li class="next {{($tamanho < 10) ? 'disabled' : ''}}"><a href="{{ ($tamanho > 10) ? route('credito.transferencia.index').$mantem.'page=2' : ""}}">Próximo</a></li>
                        @endif
                    </ul>
                </div>
                <!-- ! Pagination -->
            </div>
        </div>
    </div>

</section>
@endsection
