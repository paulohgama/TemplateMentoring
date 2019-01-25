<?php
    $sectionTitle = "Visitante";
    $sectionSubtitle = "Cadastrar visitante";
    $defaultPath = "/admin/visitante/";
    $defaultFilepath = "/public/uploads/visitante/";
?>
@extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle)
@section('title',$sectionSubtitle." - ".$sectionTitle) @section('content')
<section class="main__content content home flex-grid--wrap col calign-top">
    <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom">
        <h1 class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1>
    </div>
    <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')<h2 class="font-20 light pd-10 color-default col-12">@yield('sectionSubtitle')</h2>
        <form class="form__maquinas form flex-grid--wrap col-12 pd-10" data-type-form="default" action="{{ url('/') }}{{ $defaultPath }}cadastrar"
            method="POST" enctype="multipart/form-data"> {{ csrf_field() }}<div class="flex-grid--wrap col-12"> <span
                    class="font-small bold mg-10--bottom">Nome</span>
                <p class="font-small col-12 color-danger hidden" data-message="Nome do visitante"></p> <input type="text" class="input col-12"
                    name="nm_visitante" value="{{ old('nm_visitante') }}"/>
            </div>
            <div class="flex-grid--wrap col-12"> <span class="font-small bold mg-10--bottom">E-mail</span>
                <p class="font-small col-12 color-danger hidden" data-message="E-mail"></p> <input type="text" class="input col-12"
                    name="email" value="{{ old('email') }}" data-validate="empty" data-name="login" />
            </div>
            <div class="flex-grid--wrap col-12"> <span class="font-small bold mg-10--bottom">Senha</span>
                <p class="font-small col-12 color-danger hidden" data-message="Senha"></p> <input type="password" class="input col-12"
                    name="senha" data-validate="empty" data-name="Senha" />
            </div>
            <div class="flex-grid--wrap col-12"> <span class="font-small bold">Status</span>
                <p class="font-small col-12 color-danger hidden" data-message="Status"></p>
                <fieldset class="relative mg-10--top mg-10--bottom col-12 radio-fix">
                    <div class="col-12"> <label class="radio-inline"><input type="radio" name="status" value="1"
                                data-validate="radio" data-name="Status" checked> Ativo</label> <label class="radio-inline"><input
                                type="radio" name="status" value="0" data-validate="radio" data-name="Status"> Inativo</label></div>
                </fieldset>
            </div>
            <div class="flex-grid col-12"> <button type="submit" class="col-0 btn--second btn-nomargin is-sm mg-10--top"><i
                        class="fa fa-download fa-left"></i> Cadastrar</button></div>
        </form>
    </div>
</section> @endsection @section('js')<script type="text/javascript" src="{{ url('/js/admin/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/admin/ckfinder/ckfinder.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/admin/blog/blogCadastro.min.js') }}"></script> @endsection
