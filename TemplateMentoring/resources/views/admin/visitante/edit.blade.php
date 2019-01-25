<?php
    $sectionTitle = "Visitante";
    $sectionSubtitle = "Editar Visitante";
    $defaultPath = "/admin/visitante/";
    $defaultFilepath = "/public/uploads/visitante/";
?>
@extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle)
@section('title',$sectionSubtitle." - ".$sectionTitle) @section('content')<section class="main__content content home flex-grid--wrap col calign-top">
    <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom">
        <h1 class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1>
    </div>
    <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')<h2 class="font-20 light pd-10 color-default col-12">@yield('sectionSubtitle')</h2>
        <form class="form__maquinas form flex-grid--wrap col-12 pd-10" id="formulario_video" action="{{ url('/') }}{{ $defaultPath }}editar/{{ $visitante[0]->cd_visitante }}"
            method="POST" enctype="multipart/form-data"> {{ csrf_field() }}
            <div class="flex-grid--wrap col-12"> 
                <span class="font-small bold mg-10--bottom">Nome</span>
                <p class="font-small col-12 color-danger hidden" data-message="Nome"></p> <input type="text" class="input col-12"
                    name="nm_visitante" value="{{ $visitante[0]->nm_visitante }}" data-validate="empty"
                    data-name="Nome" />
            </div>
            <div class="flex-grid--wrap col-12"> 
                <span class="font-small bold mg-10--bottom">E-mail</span>
                <p class="font-small col-12 color-danger hidden" data-message="E-mail"></p> <input type="text" class="input col-12"
                    name="email" value="{{ $visitante[0]->email }}" data-validate="empty"
                    data-name="E-mail" />
            </div>
            <div class="flex-grid--wrap col-12"> 
                <span class="font-small col-12 bold mg-10--bottom">Créditos</span>
                <span class="font-small bold mg-10--bottom" style="padding-top:4px; padding-right:10px">Minutos:</span><input type="text" class="input" style="width:50px; height:30px" name="qt_minutos" value="{{ ($visitante[0]->qt_segundos-($visitante[0]->qt_segundos%60))/60 }}" data-validate="empty" data-name="Créditos"/>
                <div style="width:5px"></div>
                <span class="font-small bold mg-10--bottom" style="padding-top:4px; padding-right:10px">Segundos:</span><input type="text" class="input" style="width:50px; height:30px" name="qt_segundos" value="{{ $visitante[0]->qt_segundos%60 }}" data-validate="empty" data-name="Créditos"/>
            </div>
            <div class="flex-grid--wrap col-12"> <span class="font-small bold">Status</span>
                <p class="font-small col-12 color-danger hidden" data-message="Status"></p>
                <fieldset class="relative mg-10--top mg-10--bottom col-12 radio-fix">
                    <div class="col-12"> <label class="radio-inline"><input type="radio" name="status" value="1"
                                data-validate="radio" data-name="Status" {{ $visitante[0]->status == 1 ? "checked" : "" }}>
                            Ativo</label> <label class="radio-inline"><input type="radio" name="status" value="0"
                                data-validate="radio" data-name="Status" {{ $visitante[0]->status == 0 ? "checked" : "" }}>
                            Inativo</label></div>
                </fieldset>
            </div>
            <input type="hidden" name="id_user" id="id_user" value="{{$visitante[0]->cd_usuario}}">
            <div class="flex-grid col-12"> <button type="submit" class="col-0 btn--second btn-nomargin is-sm mg-10--top"><i
                        class="fa fa-download fa-left"></i> Salvar <input type="hidden" name="id" value="{{ $visitante[0]->cd_visitante }}" /></button></div>
        </form>
    </div>
</section> @endsection
