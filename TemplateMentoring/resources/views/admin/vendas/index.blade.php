<?php
    $sectionTitle = "Vendas";
    $sectionSubtitle = "Relatório";
    $defaultPath = "/admin/vendas/relatorio/";
    $defaultFilepath = "";
?>
@extends('admin.layout.master')

@section('sectionTitle',$sectionTitle)
@section('sectionSubtitle',$sectionSubtitle)
@section('title',$sectionSubtitle." - ".$sectionTitle)

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<section class="main__content content home flex-grid--wrap col calign-top">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
        $(document).ready(function()
        {
            $('#status').on('change', function(){
                window.open("{{route('filtro.status')}}"+'?status='+$(this).val()+'&termo={{$request->termo}}', '_self');
            })


        });
    </script>


    <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom">
        <h1 class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1>
    </div>
    <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')<div class="flex-grid--wrap halign-center valign-top col-12 pd-10">
            <h2 class="font-20 light mg-10--bottom color-default col mg-20--right">@yield('sectionSubtitle')</h2>
            <form class="form__maquinas form flex-grid--wrap col halign-right is-lg" action="{{ url('/') }}{{ $defaultPath }}"
                method="GET">

                <div class="flex-grid col is-lg" style="margin-left:-50%; margin-right:5%;">
                    <select name="status" id="status" class="input col-12">
                        <option value="" <?= ($request->status == ""? 'selected':'') ?>>Status</option>
                        <option value="2" <?= ($request->status == "2"? 'selected':'') ?>>Paga</option>
                        <option value="1" <?= ($request->status == "1"? 'selected':'') ?>>Aguardando pagamento</option>
                    </select>
                </div>
                <div class="flex-grid col is-lg"> <input class="input col-12" type="text" name="termo" value="{{ $filtro['termo']}}"
                        placeholder="Filtrar por campos do tipo Texto" /></div>
                <div class="flex-grid col-0 pd-10--bottom is-lg"> <button type="submit" class="col-12 btn--second btn-nomargin is-sm"><i
                            class="fa fa-search fa-left"></i> Filtrar</button></div>
            </form>
        </div>

        <div class="bg-second col-12 color-white pd-10 font-smaller">
            <p> <strong>{{ $dados->total() }}</strong> registro(s) encontrado(s)</p>
        </div>
    <table class="table table-striped col-12 responsive-table--lg">
        <thead class="thead">
            <tr class="tr">
                <th class="th pd-10 text-center" style="width: 5%">#</th>
                <th class="th pd-10">Data</th>
                <th class="th pd-10">Visitante</th>
                <th class="th pd-10">Crédito</th>
                <th class="th pd-10">Status</th>
            </tr>
        </thead>

        <tbody class="tbody"> @foreach ($dados as $dadosItem)<tr class="tr" data-id="{{$dadosItem['cd_venda']  }}">
                <td class="td pd-10 text-center" data-th="#">
                    <p class="col"> {{ $dadosItem['cd_venda'] }}</p>
                </td>
                <td class="td pd-10" data-th="Data">
                    <p class="col">
                        <?php $date=date_create($dadosItem['dt_venda']);
                            echo date_format($date,"d/m/Y"); ?>
                    </p>
                </td>
                <td class="td pd-10" data-th="Visitante">
                <a href="{{ url('/') }}/admin/visitante/visualizar/{{$dadosItem->cd_visitante}}" data-modal="user" data-id_visitante="{{$dadosItem['cd_visitante']}}">
                        <p class="col" style="font-size:15px;color:blue">{{$dadosItem['nm_visitante']}}</p>
                    </a>
                </td>
                <td class="td pd-10" data-th="Crédito">
                    <p class="col"> {{ 'R$'.number_format($dadosItem['cd_compra'], 2, ',', '.')}}</p>
                </td>
                <td class="td pd-10" data-th="Status">
                    <p class="col"> {{$dadosItem['st_status']}}</p>
                </td>
            </tr>
            @endforeach</tbody>
    </table>
    {{$dados->links()}}
</div>
</section> @endsection

