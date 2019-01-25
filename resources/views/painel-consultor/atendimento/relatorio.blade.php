@extends('painel-consultor.layouts.master')

@section('meta-title', 'Relatório Atendimento - Painel Consultor | Tarot Nova Era')
@section('meta-desc', '')

@section('meta-desc', '')

@section('breadcrumb')
<ul class="breadcrumb-list">
    <li>Você está em</li>
    <li>Home</li>
    <li>Relatório</li>
    <li>Atendimento</li>
</ul>
@endsection

@section('content')
<section id="credito-transferencias">
    <div class="search-date-box ml-0 mr-0">
        <div class="wrap-search w-100">
            <form action="" method="get">
                <label for="inicio">Buscar por data</label>
                <div class="wrap-input search">
                    <input type="text" id="search" name="termo" value="{{ $filtro['termo'] }}" placeholder="Buscar Atendimento">
                </div>
                <div class="wrap-input">                    
                    <input type="text" id="data-inicio" name="dt_inicio" placeholder="Início" value="<?php if($filtro['dt_inicial'] != '2000-12-12'){
                        $split1 = explode('-', $filtro['dt_inicial']);
                        echo $split1[2].'/'.$split1[1].'/'.$split1[0];
                    }?>">
                    <div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
                <div class="wrap-input">                    
                    <input type="text" id="data-fim" name="dt_final" placeholder="Fim" value="<?php if($filtro['dt_final'] != '2050-12-12'){
                        $split2 = explode('-', $filtro['dt_final']);
                        echo $split2[2].'/'.$split2[1].'/'.$split2[0];
                    }?>">
                    <div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                </div>
                <button type="submit">Filtrar</button>
                <a id="limpar" class="filtroRemover">limpar filtros</a>
            </form>
        </div>
    </div>

    <div class="wrap-rounded-column pt-0 pl-0 pr-0 mb-5">        
        <!-- table listing -->
        <div id="table-block">
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table">
                        @if(isset($lista[0]))
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Visitante</th>
                                <th>Data</th>
                                <th>Duração</th>
                                <th>Comissão</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lista as $listaItem)
                            <tr>
                                <td>{{$listaItem->cd_atendimento}}</td>
                                <td>{{$listaItem->nm_visitante}}</td>
                                <td>{{date('d/m/Y H:i:s', strtotime($listaItem->hr_inicio))}}</td>
                                <td><?php
                                    if($listaItem->hr_termino != null){
                                        $d1 = new DateTime( $listaItem->hr_inicio );
                                        $d2 = new DateTime( $listaItem->hr_termino );
                                        $diff = $d1->diff($d2, true);
                                        $split = explode(':',$diff->format('%H:%i:%s')); 
                                        if(strlen($split[0]) == 1){
                                            $split[0] = '0'.$split[0];
                                        }
                                        if(strlen($split[1]) == 1){
                                            $split[1] = '0'.$split[1];
                                        }
                                        if(strlen($split[2]) == 1){
                                            $split[2] = '0'.$split[2];
                                        }
                                        echo $split[0].':'.$split[1].':'.$split[2];
                                    }
                                    else{
                                        echo "--:--:--";
                                    }?>
                                </td>
                                <td>R$ {{number_format(($listaItem->vl_total * 0.4), 2)}}</td>
                                <td><a href="/painel-consultor/atendimento/visualizar/{{$listaItem->cd_atendimento}}" class="btn-details"><i class="fa fa-search" aria-hidden="true"></i><div class="text-uppercase">Ver Detalhes</div></a></td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <h4 style="padding-top:50px;text-align:center" class="name">Nenhum atendimento encontrado</h4>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="paginator" class="mt-5">
            {{$lista->links('painel-consultor.paginacao')}}
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        var spl = (window.location.href).split('?');
        $(document).ready(function(){
            $('#limpar').attr('href', spl[0]);
        });
    </script>
</section>
@endsection