<?php
    $sectionTitle = "Contato";
    $sectionSubtitle = "Gerenciar Contato";
    $defaultPath = "/admin/contato/";
    $defaultFilepath = "";
?>
@extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle)
@section('title',$sectionSubtitle." - ".$sectionTitle) @section('content')<section class="main__content content home flex-grid--wrap col calign-top">
    <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom">
        <h1 class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1>
    </div>
    <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')<div class="flex-grid--wrap halign-center valign-top col-12 pd-10">
            <h2 class="font-20 light mg-10--bottom color-default col mg-20--right">@yield('sectionSubtitle')</h2>
            <form class="form__maquinas form flex-grid--wrap col halign-right is-lg" action="{{ url('/') }}{{ $defaultPath }}"
                method="GET">
                <div class="flex-grid col is-lg"> <input class="input col-12" type="text" name="termo" value="{{ $filtro['termo'] }}"
                        placeholder="Filtrar por campos do tipo Texto" /></div>
                <div class="flex-grid col-0 pd-10--bottom is-lg"> <button type="submit" class="col-12 btn--second btn-nomargin is-sm"><i
                            class="fa fa-search fa-left"></i> Filtrar</button></div>
            </form>
        </div>
        <div class="bg-second col-12 color-white pd-10 font-smaller">
            <div class="flex-grid col-0 valign-middle">
                <p> <strong>{{ $lista->total() }}</strong> registro(s) encontrado(s)</p>
            </div>
        </div>
        <table class="table table-striped col-12 responsive-table--lg">
            <thead class="thead">
                <tr class="tr">
                    <th class="th pd-10 text-center" style="width: 5%">#</th>
                    <th class="th pd-10" style="width: 10%;">Data</th>
                    <th class="th pd-10">Nome</th>
                    <th class="th pd-10" style="width: 10%">Telefone</th>
                    <th class="th pd-10" style="width: 20%">E-mail</th>
                    <th class="th pd-10" style="width: 10%">Ações</th>
                </tr>
            </thead>
            <tbody class="tbody"> @foreach ($lista as $listaItem)<tr class="tr" data-id="{{ $listaItem->id }}">
                    <td class="td pd-10 text-center" data-th="#">
                        <p class="col"> {{ $listaItem->id }}</p>
                    </td>
                    <td class="td pd-10 text-center" data-th="#">
                        <p class="col"> {{ $listaItem->created_at->format('d/m/Y') }}</p>
                    </td>
                    <td class="td pd-10" data-th="Nome">
                        <p class="col"> {{$listaItem->nome}}</p>
                    </td>
                    <td class="td pd-10" data-th="Telefone">
                        <p class="col"> {{$listaItem->telefone}}</p>
                    </td>
                    <td class="td pd-10" data-th="E-mail">
                        <p class="col"> {{$listaItem->email}}</p>
                    </td>
                    <td class="td pd-10" data-th="Ações">
                        <div class="flex-grid col-0 valign-middle"><a href="{{ url('/') }}{{ $defaultPath }}visualizar/{{ $listaItem->id }}"
                                class="btn--info btn-small btn-noborder btn-nomargin font-small col-0 relative"><i
                                    class="fa fa-eye"></i></a> <a href="{{ $defaultPath }}excluir/{{ $listaItem->id }}"
                                prevent-default data-destroy="{{ url('/') }}{{ $listaItem->id }}" data-text-{{
                                $listaItem->id }}="Confirmar exclusão: {{ $listaItem->titulo }}" class="btn--danger
                                btn-small btn-noborder btn-nomargin font-small col-0 mg-10--left relative"><i class="fa fa-trash-o"></i></a></div>
                    </td>
                </tr> @endforeach</tbody>
        </table> {{ $lista->appends($filtro)->links() }}
    </div>
</section> @endsection
