@extends('site.layouts.master')

@section('meta-title', 'Chat Online | Tarot Nova Era')
@section('meta-desc', '')

@section('content')
<section id="breadcrumb">
    <div class="container">
        <h1>Chat Online</h1>
        <ul>
            <li>Você está em</li>
            <li><a href="/">Home</a></li>
            <li><a>Atendimento <span class="number">{{$atendimento[0]->cd_atendimento}}</span></a></li>
        </ul>
    </div>
</section>

<section id="chat">
    <div class="container">
        <div class="chat-main-wrap">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                     <!-- a comp -->
                     <div class="client-box">
                        <div class="header">
                            <h3>Conexão Iniciada</h3>
                        </div>
                        <div class="body">
                            <h5 class="name">{{$atendimento[0]->nm_visitante}}</h5>
                            <p>Atendimento {{$atendimento[0]->cd_atendimento}}</p>
                        </div>
                     </div>
                     <!-- !a comp -->

                      <!-- a comp -->
                      <div class="client-spec">
                            <div class="header">
                                <h3>Cliente</h3>
                            </div>
                            <div class="body">
                                <ul>
                                    <li>
                                        <span class="lbl">Nome</span>
                                        <span class="value">{{$atendimento[0]->nm_visitante}}</span>
                                    </li>
                                </ul>
                            </div>
                       </div>
                    <div class="user-information-status consultant">
                        <div class="header">
                            <h3>{{$atendimento[0]->nm_consultor}}</h3>
                        </div>
                        <div class="body">
                            <figure>
                                <img src="/images/especialistas/{{$atendimento[0]->img_consultor}}" alt="especialista">
                            </figure>
                        </div>
                        <div class="footer">
                            <a href="#" id="finalizar" class="btn-default"><div class="wrap">Finalizar Atendimento</div></a>
                        </div>
                    </div>
                     <!-- !a comp -->
                </div>
                <div class="col-lg-9 col-md-8">
                    <?php
                        $H = ($atendimento[0]->qt_segundos/3600 >= 10)? $atendimento[0]->qt_segundos/3600 : '0'.$atendimento[0]->qt_segundos/3600;
                        $M = (($atendimento[0]->qt_segundos/60) % 60 >= 10)? ($atendimento[0]->qt_segundos/60) % 60 : '0'.($atendimento[0]->qt_segundos/60) % 60;
                        $S = ($atendimento[0]->qt_segundos % 60 >= 10)? $atendimento[0]->qt_segundos%60 : '0'.$atendimento[0]->qt_segundos%60;
                    ?>
                    <!-- a comp -->
                    <timer-consultant
                    startvalue= "{{ intval($H).':'.intval($M).':'.intval($S) }}"
                        leftseconds= "{{ $atendimento[0]->qt_segundos }}"
                        idatendimento= "{{ $atendimento[0]->cd_atendimento }}"
                        initialganho="R$ {{number_format(($atendimento[0]->vl_total * 0.4), 2)}}"
                        valor="{{$valor->valor}}"
                        :sender="{id: {{$atendimento[0]->cd_consultor}}, name: '{{$atendimento[0]->nm_consultor}}', role: 2, chat:'{{$atendimento[0]->cd_atendimento}}'}"
                        :receiver="{id: {{$atendimento[0]->cd_visitante}}, name: '{{$atendimento[0]->nm_visitante}}', role:3}"
                    >
                    </timer-consultant>
                    <!-- !a comp -->

                    <!--- consultor 2 | visitante 3 -->
                     <chat-component :sender="{id: {{$atendimento[0]->cd_consultor}}, name: '{{$atendimento[0]->nm_consultor}}', role: 2, chat:'{{$atendimento[0]->cd_atendimento}}'}"
                        :receiver="{id: {{$atendimento[0]->cd_visitante}}, name: '{{$atendimento[0]->nm_visitante}}', role:3}"></chat-component>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $(window).on("beforeunload", function () {
        var confirmationMessage = "Sair ou atualizar a página irá cancelar o pedido de chat, deseja realmente fazer isso?";
        return confirmationMessage;
    });
    $(window).on("unload", function () {
        CreateConnectionSocket.emit('finishChat', {fromUserId: {{$atendimento[0]->cd_visitante}}, toUserId: {{$atendimento[0]->cd_consultor}}, status: 3});
    });
    $('#finalizar').click(function(){
        event.preventDefault();
        CreateConnectionSocket.emit('finishChat', {fromUserId: {{$atendimento[0]->cd_consultor}}, toUserId: {{$atendimento[0]->cd_visitante}}, status: 3});
    });
</script>
@endsection
