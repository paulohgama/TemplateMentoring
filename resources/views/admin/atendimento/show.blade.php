<?php
    $sectionTitle = "Atendimento";
    $sectionSubtitle = "Visualizar Atendimento";
    $defaultPath = "/admin/atendimento/";
    $defaultFilepath = "";
?>
@extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle)
@section('title',$sectionSubtitle." - ".$sectionTitle) @section('content')<section class="main__content content home flex-grid--wrap col calign-top">
    <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom">
        <h1 class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1>
    </div>
    <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')<h2 class="font-20 light pd-10 color-default col-12">@yield('sectionSubtitle')</h2>
        <form class="form__maquinas form flex-grid--wrap col-12 pd-10" id="formulario_video" action="" method="POST"
            enctype="multipart/form-data"> {{ csrf_field() }}
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">Atendente</span>
                <p class="font-small mg-10--bottom col-12">{{ $atendimento[0]->nm_consultor }}</p>
            </div>
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">Visitante</span>
                <p class="font-small mg-10--bottom col-12">{{ $atendimento[0]->nm_visitante }}</p>
            </div>
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">Data</span>
                <p class="font-small mg-10--bottom col-12">{{ date('d/m/Y', strtotime($atendimento[0]->dt_atendimento)) }}</p>
            </div>
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">Horario de inicio</span>
                <p class="font-small mg-10--bottom col-12"><?php $d1 = new DateTime( $atendimento[0]->hr_inicio );
                    echo $d1->format('H:i:s') ?></p>
            </div>
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">Horario de termino</span>
                <p class="font-small mg-10--bottom col-12"><?php $d2 = new DateTime( $atendimento[0]->hr_termino );
                    echo $d2->format('H:i:s') ?>
                </p>
            </div>
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">Duração total</span>
                <p class="font-small mg-10--bottom col-12"><?php 
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
                ?></p>
            </div>
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">Valor total</span>
                <p class="font-small mg-10--bottom col-12">R$ {{number_format($atendimento[0]->vl_total, 2)}}</p>
            </div>
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">Comissão do consultor</span>
                <p class="font-small mg-10--bottom col-12">R$ {{number_format(($atendimento[0]->vl_total * 0.4), 2)}}</p>
            </div>
            @if(isset($mensagens[0]))
            <div class="flex-grid--wrap col-12 text-center" style="padding-top:25px"> <span class="font-small bold mg-10--bottom col-12">Mensagens trocadas</span>
                @foreach($mensagens as $msg)
                @if ($msg->cd_msgporconsultor == 1)
                    <div class="flex-grid--wrap text-right" style="background-color: rgb(220,220,220)">
                        <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">{{$atendimento[0]->nm_consultor}}</span>
                            <p class="font-small mg-10--bottom col-12">{{$msg->ds_mensagem}}</p>
                        </div>
                    </div>
                @else
                    <div class="flex-grid--wrap text-left">
                        <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">{{$atendimento[0]->nm_visitante}}</span>
                            <p class="font-small mg-10--bottom col-12">{{$msg->ds_mensagem}}</p>
                        </div>
                    </div>
                @endif
                @endforeach
            </div>
            @else
            <div class="flex-grid--wrap col-12 text-center" style="padding-top:25px"> <span class="font-small bold mg-10--bottom col-12">Não foram trocadas mensagens nesse atendimento</span>
            @endif
        </form>
    </div>
</section> @endsection
