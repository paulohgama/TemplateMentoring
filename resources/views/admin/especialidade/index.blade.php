<?php
$sectionTitle = "Especialidade";
$sectionSubtitle = "Gerenciar Especialidade";
$defaultPath = "/admin/especialidade/";
?> @extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle) @section('title',$sectionSubtitle." - ".$sectionTitle) @section('content')
    <section class="main__content content home flex-grid--wrap col calign-top">
        <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom">
            <h1 class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1>
        </div>
        <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')
            <div class="flex-grid--wrap halign-center valign-top col-12 pd-10">
                <h2 class="font-20 light mg-10--bottom color-default col mg-20--right">@yield('sectionSubtitle')</h2>
                <form class="form__maquinas form flex-grid--wrap col halign-right is-lg" action="{{ url('/admin/especialidade/listar') }}" method="GET">
                    <div class="flex-grid col is-lg">
                        <input class="input col-12" type="text" name="termo" value="" placeholder="Filtrar por campos do tipo Texto"/>
                    </div>
                    <div class="flex-grid col-0 pd-10--bottom is-lg">
                        <button type="submit" class="col-12 btn--second btn-nomargin is-sm">
                            <i class="fa fa-search fa-left"></i> Filtrar
                        </button>
                    </div>
                </form>
            </div>
            <div class="bg-second col-12 color-white pd-10 font-smaller">
                <div class="flex-grid col-0 valign-middle">
                    <a href="{{ url('/') }}{{ $defaultPath }}cadastrar" class="btn--success btn-small btn-noborder btn-nomargin font-small mg-10--right col-0 relative">
                        <i class="fa fa-plus-square col-0"></i>
                    </a>
                    <p><strong>{{ $lista->total() }}</strong> registro(s) encontrado(s)</p>
                </div>
            </div>
            <table class="table table-striped col-12 responsive-table--lg">
                <thead class="thead">
                <tr class="tr">
                    <th class="th pd-10 text-center" style="width: 5%">#</th>
                    <th class="th pd-10">Nome</th>
                    <th class="th pd-10" style="width: 10%">Ações</th>
                </tr>
                </thead>
                <tbody class="tbody">
                @forelse ($lista as $listaItem)
                    <tr class="tr" data-id="{{ $listaItem->cd_especialidade }}">
                        <td class="td pd-10 text-center" data-th="#"><p class="col"> {{ $listaItem->cd_especialidade }}</p></td>
                        <td class="td pd-10" data-th="Nome"><p class="col"> {{ $listaItem->nm_especialidade }}</p></td>
                        <td class="td pd-10" data-th="Ações">
                            <div class="flex-grid col-0 valign-middle">
                                <a href="{{ url('/') }}{{ $defaultPath }}editar/{{ $listaItem->cd_especialidade }}" class="btn--success btn-small btn-noborder btn-nomargin font-small col-0 relative">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a href="{{ url('/') }}{{ $defaultPath }}excluir/{{ $listaItem->cd_especialidade }}" prevent-default data-destroy="{{ $listaItem->cd_especialidade }}" data-text-{{ $listaItem->cd_especialidade }}="Confirmar exclusão: {{ $listaItem->nm_especialidade }}" class="btn--danger btn-small btn-noborder btn-nomargin font-small col-0 mg-10--left relative">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <td colspan="2" class="text-center">Não há especialidades</td>
                @endforelse
                </tbody>
            </table>
            {{ $lista->links() }}
        </div>
    </section>
@endsection