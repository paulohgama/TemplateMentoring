<?php
    $sectionTitle = "Parceiro";
    $sectionSubtitle = "Editar Parceiro";
    $defaultPath = "/admin/parceiro/";
    $defaultFilepath = "/public/uploads/parceiro/";
?> @extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle) @section('title',$sectionSubtitle." - ".$sectionTitle) @section('content')<section class="main__content content home flex-grid--wrap col calign-top"><div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom"><h1 class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1></div><div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')<h2 class="font-20 light pd-10 color-default col-12">@yield('sectionSubtitle')</h2><form class="form__maquinas form flex-grid--wrap col-12 pd-10" id="formulario_video" action="{{ url('/') }}{{ $defaultPath }}editar/{{ $item->id }}" method="POST" enctype="multipart/form-data"> {{ csrf_field() }}<div class="flex-grid--wrap col-12"> <span class="font-small bold mg-10--top mg-10--bottom">Categoria</span><p class="font-small col-12 color-danger hidden" data-message="Categoria"></p> <select class="input col-12" name="parceiro_categoria_id" data-validate="empty" data-name="Categoria do Parceiro" value="{{ old('parceiro_categoria_id') }}"> @foreach ($listaCategoria as $listaCategoriaItem)<option value="{{ $listaCategoriaItem->id }}" {{ $listaCategoriaItem->id == $item->parceiro_categoria_id ? "selected" : "" }}>{{ $listaCategoriaItem->nome }}</option> @endforeach</select></div><div class="flex-grid--wrap col-12"> <span class="font-small bold mg-10--bottom">Nome</span><p class="font-small col-12 color-danger hidden" data-message="Nome"></p> <input type="text" class="input col-12" name="nome" value="{{ old('nome') ?? $item->nome }}" data-validate="empty" data-name="Nome"/></div><div class="flex-grid--wrap col-12"> <span class="font-small bold mg-10--bottom">Telefone</span><p class="font-small col-12 color-danger hidden" data-message="Telefone"></p> <input type="text" class="input col-12" name="telefone" value="{{ old('telefone') ?? $item->telefone }}" data-validate="empty" data-name="Telefone"/></div><div class="flex-grid--wrap col-12"> <span class="font-small bold mg-10--bottom">Endereço</span><p class="font-small col-12 color-danger hidden" data-message="Endereço"></p> <textarea class="input col-12" name="endereco" data-validate="empty" data-name="Endereço">{{ old('endereco') ?? $item->endereco }}</textarea></div><div class="flex-grid--wrap col-12"> <span class="font-small bold mg-10--bottom">Descrição</span><p class="font-small col-12 color-danger hidden" data-message="Descrição"></p><div class="col-12"> <textarea name="descricao">{{ old('descricao') ?? $item->descricao }}</textarea></div></div><div class="flex-grid--wrap col-12 mg-10--top mg-10--bottom"> <span class="font-small bold mg-10--right">Logo atual</span> <button class="fancybox-link btn--info btn-small btn-noborder btn-nomargin font-small relative" prevent-default data-fancybox-images="{{ $defaultFilepath . $item->imagem }}"><i class="fa fa-image"></i></button> <input type="file" class="input col-12" name="imagem" value="{{ old('imagem') ?? $item->imagem }}" data-name="Logo" size="20"/></div><div class="flex-grid--wrap col-12"> <span class="font-small bold">Status</span><p class="font-small col-12 color-danger hidden" data-message="Status"></p><fieldset class="relative mg-10--top mg-10--bottom col-12 radio-fix"><div class="col-12"> <label class="radio-inline"><input type="radio" name="status" value="1" data-validate="radio" data-name="Status" {{ $item->status == 1 ? "checked" : "" }}> Ativa</label> <label class="radio-inline"><input type="radio" name="status" value="0" data-validate="radio" data-name="Status" {{ $item->status == 0 ? "checked" : "" }}> Inativa</label></div></fieldset></div><div class="flex-grid col-12"> <button type="submit" class="col-0 btn--second btn-nomargin is-sm mg-10--top"><i class="fa fa-download fa-left"></i> Salvar <input type="hidden" name="id" value="{{ $item->id }}"/></button></div></form></div></section> @endsection @section('js')<script type="text/javascript" src="{{ url('/js/admin/ckeditor/ckeditor.js') }}"></script><script type="text/javascript" src="{{ url('/js/admin/ckfinder/ckfinder.js') }}"></script><script type="text/javascript" src="{{ url('/js/admin/parceiro/parceiroCadastro.min.js') }}"></script> @endsection