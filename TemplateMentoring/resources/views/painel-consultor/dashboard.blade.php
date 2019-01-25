@extends('painel-consultor.layouts.master')

@section('meta-title', 'Dashboard - Painel Consultor | Tarot Nova Era')
@section('meta-desc', '')

@section('meta-desc', '')

@section('breadcrumb')
<ul class="breadcrumb-list">
    <li>Você está em</li>
    <li>Home</li>
    <li>Dashboard</li>
</ul>
@endsection

@section('content')
<section class="connections-infos">
    <div id="vue-app">
        <consultant-notification consultantid="{{Auth::user()->cd_usuario_fk}}"></consultant-notification>
    </div>
    <div class="row r-m">
        <div class="col-md-6">
            <div class="wrap-rounded-column">
                <h4>Seu status</h4>
                <div class="status-radio-box">
                    <div class="btn-box online">
                        <input type="radio" name="status" id="statusOnline" <?= ($consultor->st_status == "online"? 'checked':'') ?> value="online">
                        <div class="text">Online</div>
                    </div>
                    <div class="btn-box ocupado">
                        <input type="radio" name="status" id="statusOcupado" <?= ($consultor->st_status == "ocupado"? 'checked':'') ?> value="ocupado">
                        <div class="text">ocupado</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="wrap-rounded-column">
                <h4>Seus créditos</h4>
                <p class="color-green paragraph text-uppercase mb-1">Créditos disponíveis</p>
                    <span class="total-credit">{{ 'R$'.number_format($consultor['qt_creditos'], 2, ',', '.')}}
                </span>
                <div class="text-center">
                    <a href="{{route('credito.transferencia.index')}}" class="btn-consult"><i class="fa fa-search" aria-hidden="true"></i> Consultar relatórios</a>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<section id="search-hangs">
    <div class="container-fluid">
        <label for="search" class="mb-0">Últimos atendimentos</label>
        <form action="" method="post" id="formularioPesquisa">
            <div class="search-wrap">
                <input type="text" id="search" name="search">
                <button id="pesquisa" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </form>


        <a href="/painel-consultor/atendimento/relatorios" class="btn-consult">ver todos atendimentos</a>
    </div>
</section>

<!-- table listing -->
<div id="table-block">
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Visitante</th>
                        <th>Data</th>
                        <th>Duração</th>
                        <th>Comissão Ganha</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($dados->count() == 0)
                    <tr>
                        <td style="text-align: center" colspan="6">
                            <i> Nenhum atendimento realizado </i>
                        </td>
                    </tr>
                    @else
                        @foreach ($dados as $atendimento)
                        <tr>
                            <td>{{$atendimento->cd_atendimento}}</td>
                            <td>{{$atendimento->nm_visitante}}</td>
                            <td>{{date('d/m/Y H:i:s', strtotime($atendimento->hr_inicio))}}
                            </td>
                            <td>{{$atendimento->tempo}}</td>
                            <td>{{'R$'.number_format($atendimento->comissao, 2, ',', '.')}}</td>
                        <td><a href="/painel-consultor/atendimento/visualizar/{{$atendimento->cd_atendimento}}" class="btn-details"><i class="fa fa-search" aria-hidden="true"></i><div>Ver Detalhes</div></a></td>
                        </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
@section('js')
<script>
    $(document).ready(function(){
        var socket = io(WS_URL);

        $('#search').keypress(function (e) {
            var code = null;
            code = (e.keyCode ? e.keyCode : e.which);
            if(code == 13) { pesquisaAtendimento(); return false;} else { return true; }
        });

        $('.btn-box').on('click', function(){
            var param = $("input[name='status']:checked").val();
            console.log('param: ', param)
            $.ajax({
                "url": "{{route('altera.status.ajax')}}",
                "method": "get",
                "dataType": "json",
                "data": {status: param },
                "success": function(data){
                    $('#status'+data.status).prop('checked', true);
                    if(param == 'online') {
                        socket.emit('statusConsultor', {id_consultor: {{Auth::user()->cd_usuario_fk}} , status: true});
                    }else {
                        socket.emit('statusConsultor', {id_consultor: {{Auth::user()->cd_usuario_fk}}, status: false});
                    }
                }
            });
        })

        /*Aqui entra o evento para disparar o ajax do bloco de iniciar o atendimento*/
        // $('.btn-box').on('click', function(){
        //     console.log('status: 2')
        //     var param = $("input[name='status']:checked").val();
        //     $.ajax({
        //         "url": "{{route('altera.status.ajax')}}",
        //         "method": "get",
        //         "dataType": "json",
        //         "data": {status: param },
        //         "success": function(data)
        //         {
        //             $('#status'+data.status).prop('checked', true);
        //             socket.emit('statusConsultor');
        //         }
        //     });
        // })

        $('#pesquisa').on('click', function(e){
            e.preventDefault();
            pesquisaAtendimento();
        });
        function pesquisaAtendimento()
        {
            var param = $('#formularioPesquisa').serializeArray();
            var pesquisa = param[0].value;
            window.open("{{route('atendimento.relatorio')}}"+'?termo='+pesquisa+'&dt_inicio=&dt_final=', '_self');
        }
    })
</script>
@endsection
