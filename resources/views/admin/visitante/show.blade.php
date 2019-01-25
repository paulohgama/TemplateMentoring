<?php
    $sectionTitle = "Visitante";
    $sectionSubtitle = "Visualizar Visitante";
    $defaultPath = "/admin/visitante/";
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
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">Nome</span>
                <p class="font-small mg-10--bottom col-12">{{ $visitante[0]->nm_visitante }}</p>
            </div>
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">E-mail</span>
                <p class="font-small mg-10--bottom col-12">{{ $visitante[0]->email }}</p>
            </div>
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">Status</span>
                <p class="font-small mg-10--bottom col-12">{{ ($visitante[0]->status == 1) ? 'Ativo' : 'Inativo' }}</p>
            </div>
            <div class="flex-grid--wrap"> <span class="font-small bold mg-10--bottom col-12">Crédito</span>
                <p class="font-small mg-10--bottom col-12">{{ ($visitante[0]->qt_segundos-($visitante[0]->qt_segundos%60))/60 }} minutos e {{$visitante[0]->qt_segundos%60}} segundos</p>
            </div>
        </form>
    </div>
</section> @endsection
