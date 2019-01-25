<?php
	$sectionTitle = "Atendimentos";
	$sectionSubtitle = "Gerenciar Atendimentos";
	$defaultPath = "/admin/atendimento/";
	// $defaultFilepath = "/uploads/atendimentos/";
	$defaultFilepath = "/public/uploads/atendimentos/";
?>
@extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle)
@section('title',$sectionSubtitle." - ".$sectionTitle) @section('content')<section class="main__content content home flex-grid--wrap col calign-top">
    <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom">
        <h1 class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1>
    </div>
    <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')
		<div class="flex-grid--wrap halign-center valign-top col-12 pd-10">
            <h2 class="font-20 light mg-10--bottom color-default col mg-20--right">@yield('sectionSubtitle')</h2>
            <form class="form__maquinas form flex-grid--wrap col halign-right is-lg" action="atendimento" method="Get">
                <div class="flex-grid col is-lg">
					<input class="input col-4" type="text" name="termo" value="{{ $filtro['termo'] }}" placeholder="Filtrar por consultor" />
					<input class="input col-4" type="text" name="dt_inicio" id="dt_inicio" value="<?php if($filtro['dt_inicial'] != '2000-12-12'){
                        $split1 = explode('-', $filtro['dt_inicial']);
                        echo $split1[2].'/'.$split1[1].'/'.$split1[0];
                    }?>" placeholder="Filtrar por dia minimo" />
					<input class="input col-4" type="text" name="dt_final" id="dt_final" value="<?php if($filtro['dt_final'] != '2050-12-12'){
                        $split2 = explode('-', $filtro['dt_final']);
                        echo $split2[2].'/'.$split2[1].'/'.$split2[0];
                    }?>" placeholder="Filtrar por dia maximo" />
                    <input type="hidden" name="visitante" id="visitante" value="{{ $filtro['visitante'] }}">
                    <input type="hidden" name="consultor" id="consultor" value="{{ $filtro['consultor'] }}">
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
                <p> <strong>{{ $lista->total() }}</strong> registro(s) encontrado(s) no total</p>
            </div>
        </div>
        <table class="table table-striped col-12 responsive-table--lg">
            <thead class="thead">
                <tr class="tr">
                    <th class="th pd-10 text-center" style="width: 5%">#</th>
                    <th class="th pd-10">Consultor</th>
                    <th class="th pd-10" style="width: 10%">Data</th>
                    <th class="th pd-10" style="width: 10%">Duração</th>
                    <th class="th pd-10" style="width: 10%">Comissão</th>
					<th class="th pd-10" style="width: 10%">Valor total</th>
					<th class="th pd-10" style="width: 10%">Ações</th>
                </tr>
            </thead>
            <tbody class="tbody"> @forelse ($lista as $listaItem)
            <tr class="tr" data-id="{{ $listaItem->cd_atendimento }}">
                    <td class="td pd-10 text-center" data-th="#">
                        <p class="col"> {{ $listaItem->cd_atendimento }}</p>
                    </td>
                    <td class="td pd-10" data-th="Consultor">
                        <p class="col"> {{$listaItem->nm_consultor}}</p>
                    </td>
                    <td class="td pd-10" data-th="Data">
                        <p class="col"> {{date('d/m/Y', strtotime($listaItem->dt_atendimento))}}</p>
                    </td>
                    <td class="td pd-10" data-th="Duração">
						<p class="col"> <?php 
                            $d1 = new DateTime( $listaItem->hr_inicio );
                            $d2 = new DateTime( $listaItem->hr_termino );
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
                    </td>
                    <td class="td pd-10" data-th="Comissão">
                        <p class="col"> R$ {{number_format(($listaItem->vl_total * 0.4), 2)}}</p>
                    </td>
                    <td class="td pd-10" data-th="vl_total">
                        <p class="col"> R$ {{number_format($listaItem->vl_total, 2)}}</p>
                    </td>
                    <td class="td pd-10" data-th="Ações">
                        <div class="flex-grid col-0 valign-middle">
                        <a href="{{ url('/') }}{{ $defaultPath }}visualizar/{{ $listaItem->cd_atendimento }}" class="btn--info btn-small btn-noborder btn-nomargin font-small col-0 relative"><i class="fa fa-eye"></i></a>
                    </td>
                </tr> @endforeach</tbody>
        </table>
        {{ $lista->links() }}
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
    $(document).ready(function(){
        $( "#dt_inicio" ).datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
        });
        $( "#dt_final" ).datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
        });
    });
    </script>
</section> @endsection
