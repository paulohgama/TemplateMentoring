<?php
	$sectionTitle = "Atendimento";
	$sectionSubtitle = "Cadastrar valor. Valor atual: ". $valor[0]->valor ;
	$defaultPath = "/admin/atendimento/";
	// $defaultFilepath = "/uploads/slide/";
	$defaultFilepath = "/public/uploads/atendimento/";
?>
@extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle)
@section('title',$sectionSubtitle." - ".$sectionTitle) @section('content')<section class="main__content content home flex-grid--wrap col calign-top">
    <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom">
        <h1 class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1>
    </div>
    <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')<h2 class="font-20 light pd-10 color-default col-12">@yield('sectionSubtitle')</h2>
        <form class="form__maquinas form flex-grid--wrap col-12 pd-10" data-type-form="default" action="{{ url('/') }}{{ $defaultPath }}cadastrar"
            method="POST" enctype="multipart/form-data"> {{ csrf_field() }}
			<div class="flex-grid--wrap col-12"> <span
                    class="font-small bold mg-10--bottom">Valor por minuto </span>
                <p class="font-small col-12 color-danger hidden" data-message="Valor"></p> 
				<input id="valor" type="text" class="input col-12" name="valor" value="" data-validate="empty" data-name="Valor" />
            </div>
            <div class="flex-grid col-12"> <button type="submit" class="col-0 btn--second btn-nomargin is-sm mg-10--top"><i
                        class="fa fa-download fa-left"></i> Cadastrar</button></div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="public/js/jquery.mask.js" ></script>
    <script>
    $(document).ready(function () {
        $('#valor').mask("000,00", {reverse: true});
    });
    </script>
</section> @endsection
