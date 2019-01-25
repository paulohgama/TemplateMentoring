<?php
$sectionTitle = "Especialidade";
$sectionSubtitle = "Alterar Especialidade";
$defaultPath = "/admin/especialidade/editar";
?>
@extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle) @section('title',$sectionSubtitle." - ".$sectionTitle) @section('content')
    <section class="main__content content home flex-grid--wrap col calign-top">
        <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom"><h1
                    class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1></div>
        <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')
            <div class="flex-grid--wrap halign-center valign-top col-12 pd-10">
                <h2 class="font-20 light mg-10--bottom color-default col mg-20--right">@yield('sectionSubtitle')</h2>
                <form class="form__maquinas form flex-grid--wrap col-12 pd-10"
                      action="{{ url('admin/especialidade/atualizar/'.$resultado->cd_especialidade) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--bottom">Nome</span>
                        <p class="font-small col-12 color-danger hidden" data-message="Nome"></p>
                        <input type="text" class="input col-12" name="nm_especialidade" value="{{$resultado->nm_especialidade}}" data-validate="empty" data-name="Especialidade">
                        <button type="submit" class="col-0 btn--second btn-nomargin is-sm mg-10--top"><i class="fa fa-download fa-left"></i> Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection