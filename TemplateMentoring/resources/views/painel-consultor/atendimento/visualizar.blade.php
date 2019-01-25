@extends('painel-consultor.layouts.master')

@section('meta-title', 'Atendimento Finalizado - Painel Consultor | Tarot Nova Era')
@section('meta-desc', '')

@section('meta-desc', '')

@section('breadcrumb')
<ul class="breadcrumb-list">
    <li>Você está em</li>
    <li>Home</li>
    <li>Relatório</li>
    <li>Atendimento {{$atendimento[0]->cd_atendimento}}</li>
</ul>
@endsection
@section('content')

<section id="atendimento">
    <div class="row">
        <aside class="col-md-3 atendimento-info-box">
            <div class="wrap">
                <h3 class="title">Atendimento</h3>
                <ul class="atendimento-list">
                    <li>
                        <span class="lbl">ID</span>
                        <span class="value">{{$atendimento[0]->cd_atendimento}}</span>
                    </li>
                    <li>
                        <span class="lbl">Início</span>
                        <span class="value">{{date('d/m/Y H:i:s', strtotime($atendimento[0]->hr_inicio))}}</span>
                    </li>
                    <?php $classe = $atendimento[0]->status_atendimento; ?>
                    @if ($classe != 2 && $classe != 0)
                    <li>
                        <span class="lbl">Cobrança iniciada?</span>
                        <span class="value"><?php
                            $d1 = new DateTime( $atendimento[0]->hr_inicio );
                            $d2 = new DateTime( $atendimento[0]->hr_cobranca );
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
                        ?></span>
                    </li>
                    <li>
                        <span class="lbl">início da cobrança</span>
                        <span class="value">{{date('d/m/Y H:i:s', strtotime($atendimento[0]->hr_cobranca))}}</span>
                    </li>
                    <li>
                        <span class="lbl">Término do atendimento</span>
                        <span class="value">{{date('d/m/Y H:i:s', strtotime($atendimento[0]->hr_termino))}}</span>
                    </li>
                    <li>
                        <span class="lbl">Duração</span>
                        <span class="value"><?php
                                        $d1 = new DateTime( $atendimento[0]->hr_inicio );
                                        $d2 = new DateTime( $atendimento[0]->hr_termino );
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
                                    ?></span>
                    </li>
                    <li>
                        <span class="lbl">Comissão</span>
                        <span class="value">R$ {{number_format(($atendimento[0]->vl_total * 0.4), 2)}}</span>
                    </li>
                  @endif
                </ul>
                <h3 class="title">Cliente</h3>
                <span class="name">{{$atendimento[0]->nm_visitante}}</span>
            </div>
        </aside>

        <div class="col-md-9">
            <!--
                ATENDIMENTO CLASSES DE STATUS:
                how to use: status-box #classname#
                classnames: credito-insuficiente, timeout,
                finalizado-atendente, finalizado-cliente

            -->
            @php
                if($classe == 1):
                    $text1 = 'Créditos insuficientes';
                    $text2 = 'Creditos insuficientes';
                    $classe = 'credito-insuficiente';
                endif;
                if($classe == 2 || $classe == 0):
                    $text1 = 'Timeout do atendente';
                    $text2 = 'Chamada não atendida';
                    $classe = 'timeout';
                endif;
                if($classe == 3):
                    $text1 = 'Atendente';
                    $text2 = 'Atendimento Finalizado';
                    $classe = 'finalizado-atendente';
                endif;
                if($classe == 4):
                    $text1 = 'Cliente';
                    $text2 = 'Atendimento Finalizado';
                    $classe = 'finalizado-cliente';
                endif;
            @endphp

            <div class="status-box {{ $classe }} wrap">
                <div class="padded">
                    <div class="main">
                        <div class="icon"></div>
                        <p>
                            Atendimento finalizado por
                            <span>{{ $text1 }}</span>
                        </p>
                    </div>
                </div>
                <div class="watchout">
                    <h5>Atenção</h5>
                    <p>{{ $text2 }}</p>
                </div>
            </div>

            <!-- Table Starts here -->
            <div class="chat-talk-box wrap">
                <h4>Mensagens Enviadas:</h4>
                <!-- TABLE -->
                @if(!isset($mensagens[0]))
                    <div class="is-empty">Nenhuma mensagem enviada neste atendimento!</div>
                @else
                <div id="table-block" class="mt-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Origem</th>
                                    <th>Data</th>
                                    <th>Mensagem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mensagens as $m)
                                <tr>
                                    <td>@if($m->cd_msgporconsultor == 0)<span class="user-cliente">Cliente</span>@elseif($m->cd_msgporconsultor == 1)<span class="user-atendente">Atendente</span>@endif</td>
                                    <td>{{date('d/m/Y H:i:s', strtotime($m->created_at))}}</td>
                                    <td>{{$m->ds_mensagem}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- FIM TABLE -->
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
