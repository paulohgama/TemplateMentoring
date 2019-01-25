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
            <li><a>Atendimento <span class="number">#{{$atendimento[0]->cd_atendimento}}</span></a></li>
        </ul>
    </div>
</section>

<section id="chat">
    <div class="container">
        <div class="chat-main-wrap">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <!-- a comp -->
                    <div class="user-information-status">
                        <div class="header">
                            <h3>Atendimento Iniciado</h3>
                        </div>
                        <div class="body">
                            <h5 class="name">{{$atendimento[0]->nm_consultor}}</h5>
                            <p>Atendimento #{{$atendimento[0]->cd_atendimento}}</p>
                            <figure>
                                <img src="/images/especialistas/{{$atendimento[0]->img_consultor}}" alt="especialista">
                            </figure>
                        </div>
                        <div class="footer">
                            <form action="" method="Post">
                                <button type="Submit" class="btn-default" id="finalizar"><div class="wrap">Finalizar Atendimento</div></button>
                            </form>
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
                    <timer-visitor
                        startvalue= "{{ intval($H).':'.intval($M).':'.intval($S) }}"
                        leftseconds= "{{ $atendimento[0]->qt_segundos }}"
                        idatendimento= "{{ $atendimento[0]->cd_atendimento }}"
                        :sender="{id: {{$atendimento[0]->cd_visitante}}, name: '{{$atendimento[0]->nm_visitante}}', role: 3, chat: '{{$atendimento[0]->cd_atendimento}}'}"
                        :receiver="{id: {{$atendimento[0]->cd_consultor}}, name: '{{$atendimento[0]->nm_consultor}}', role: 2}">
                    </timer-visitor>
                    <!-- !a comp -->

                    <!--- consultor 2 | visitante 3 -->
                    <chat-component :sender="{id: {{$atendimento[0]->cd_visitante}}, name: '{{$atendimento[0]->nm_visitante}}', role: 3, chat: '{{$atendimento[0]->cd_atendimento}}'}"
                        :receiver="{id: {{$atendimento[0]->cd_consultor}}, name: '{{$atendimento[0]->nm_consultor}}', role: 2}">
                    </chat-component>
                </div>
            </div>
        </div>
    </div>
</section>

@include('site.includes.rate-avaliation');

@endsection

@section('js')
<script>
    $(window).on("beforeunload", function () {
        var confirmationMessage = "Sair ou atualizar a página irá cancelar o pedido de chat, deseja realmente fazer isso?";
        return confirmationMessage;
    });
    $(window).on("unload", function () {
        CreateConnectionSocket.emit('finishChat', {fromUserId: {{$atendimento[0]->cd_visitante}}, toUserId: {{$atendimento[0]->cd_consultor}}, status: 4});
    });
    MainObj.events.ratingstarchoose();

    $('#avaliation-modal').on('hidden.bs.modal', function () {
        window.location.href = '/';
    });
    $('#depoimento').click(function(){
        $('#avaliation-modal').modal('hidden');
    });
    $('#finalizar').click(function(){
        event.preventDefault();
        CreateConnectionSocket.emit('finishChat', {fromUserId: {{$atendimento[0]->cd_visitante}}, toUserId: {{$atendimento[0]->cd_consultor}}, status: 4});
    });
</script>
@endsection

