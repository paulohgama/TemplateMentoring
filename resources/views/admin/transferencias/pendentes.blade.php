<?php
    $sectionTitle = "Transferencias";
    $sectionSubtitle = "Pendentes";
    $defaultPath = "/admin/transferencias/pendentes/";
    $defaultFilepath = "";
?>
@extends('admin.layout.master')
@section('sectionTitle',$sectionTitle)
@section('sectionSubtitle',$sectionSubtitle)
@section('title',$sectionTitle." ".$sectionSubtitle)

@section('content')
<section class="main__content content home flex-grid--wrap col calign-top">
<style>
    #nome {
        margin: 0;
        font-weight: 300;
        font-size: 1.0em;
        margin-bottom: 15px;
    }
    .form-group label {
        font-size: 16px;
    }
    a[disabled="disabled"] {
    pointer-events: none;
}
</style>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- undoing some bootstrap overrides -->
<style>
    ol, ul {
        margin-bottom: inherit!important;
    }
    .table .td {
        font-size: 14px!important;
    }
    .pd-10 {
        padding: 10px!important;
    }
    .table .th, .table .td {
        color: #494949!important;
    }
    .table>tbody>tr>td {
        font-size: 14px!important;
        vertical-align: middle;
    }
    .table>thead>tr>th {
        border-bottom: none;
    }
    .table .btn.btn-success {
        padding: 10px 14px 0;
    }
</style>

    <script type="text/javascript">
        $(document).ready(function () {
            var availableDates = [];
            var datasC = [];
            var precos = [];
            $.noConflict();
            var paginaAtual = 1;
            var paginaMaxima = 1;
            $('#termo').val(localStorage.getItem('pesquisapendente'));
            tabela(localStorage.getItem('pesquisapendente'));
            $('input').keypress(function (e) {
                var code = null;
                code = (e.keyCode ? e.keyCode : e.which);
                if(code == 13)
                {
                    pesquisar();
                    return false;
                }
                return true;
            });
            $('#pesquisa').click(function () {
                pesquisar();
            });
            function pesquisar()
            {
                var parametros = $('#formPesquisa').serializeArray();
                paginaAtual = 1;
                tabela(parametros[0].value);
                localStorage.setItem('pesquisapendente', parametros[0].value);
            }
            function tabela(pesquisa) {
                $.ajax({
                    "url": "{{route('admin.transf.pendentens')}}",
                    "dataType": 'json',
                    "method": 'post',
                    'data': {
                        _token: '{{csrf_token()}}',
                        termo: pesquisa,
                        pagina: (getUrlParameter('page') === undefined) ? 1 : getUrlParameter('page')
                    },
                    success: function (dados) {
                        $("#corpoTabela").empty();
                        $.each(dados, function (i, linha) {
                            if(dados.length > 1){
                                if(i < dados.length-1){
                                    var linhaRegistro = "<tr class='tr'>";
                                    var total = parseFloat(Math.round(linha.valortotal * 100) / 100)
                                        .toFixed(
                                            2);
                                    var comissao = parseFloat(Math.round(linha.comissao * 100) /
                                        100).toFixed(
                                        2);
                                    linhaRegistro += "<td class='th pd-10'><p class='col'>" + linha.nome +
                                        "</p></td>";
                                    linhaRegistro += "<td class='th pd-10'><p class='col'>" + linha.datainicio +
                                        "</p></td>";
                                    linhaRegistro += "<td class='th pd-10'><p class='col'>" + linha.datafim +
                                        "</p></td>";
                                    linhaRegistro += "<td class='th pd-10'><p class='col'>R$ " + total
                                        .replace(
                                            ".", ",") + "</p></td>";
                                    linhaRegistro += "<td class='th pd-10'><p class='col'>R$ " +
                                        comissao.replace(
                                            ".", ",") + "</p></td>";
                                    linhaRegistro += "<td class='th pd-10'><p class='col'>" + linha.atendimentos +
                                        "</p></td>";
                                    linhaRegistro += "<td class='th pd-10 text-center'>" + linha.botao +
                                        "</td>";
                                    linhaRegistro += "</tr>"
                                    $("#corpoTabela").append(linhaRegistro).show();
                                }
                            }
                            else
                            {
                                var linhaRegistro = "<tr class='tr'>";
                                    linhaRegistro += "<td class='th pd-10' align='center' colspan='7'><i><p class='col'>Nenhum atendimento sem baixa</p></i></td>";
                                        linhaRegistro += "</tr>"
                                    $("#corpoTabela").append(linhaRegistro).show();
                            }
                        });
                        $("#qntRegistros").html(dados[dados.length-1] + " ").show();
                        paginaMaxima = parseInt((dados[dados.length-1]-1)/10)+1;
                        paginar(paginaMaxima);
                    },
                    error: function (dados) {

                    }

                });
            }
            $(document).on('click', '[data-modal="user"]', function (event) {
                availableDates = [];
                precos = [];
                datasC = [];
                $("#datainicio").datepicker("destroy");
                $("#datafim").datepicker("destroy");
                $("#datainicio").val("");
                $("#datafim").val("");
                event.preventDefault();
                var parametros = {
                    consultor: $(this).data('consultor'),
                    _token: "{{csrf_token()}}"
                }
                $.ajax({
                    "url": "{{route('admin.transf.pendentes.consultor')}}",
                    "dataType": "json",
                    "method": 'post',
                    "data": parametros,
                    "success": function (dados) {
                        $.each(dados.valoresDatas, function (i, obj) {
                            availableDates[i] = obj.data;
                            precos[i] = obj.valor;
                            datasC[i] = obj.dataC;
                        });
                        $("#nome").html("Nome: " + dados.nome);
                        document.getElementById("valor").value = "Valor: " + APagar(precos);
                        document.getElementById("datainicio").value = datasC[0];
                        document.getElementById("datafim").value = datasC[datasC.length - 1];
                        document.getElementById("cd_consultor").value = dados.id;
                        $('#myModal').modal('show');
                        datas(availableDates);
                    }
                });
            });

            function dataInicio(datainicio) {
                var tratar = datainicio.split("/");
                var dataInicial = new Date(tratar[2] + "-" + tratar[1] + "-" + tratar[0]);
                let valorTotal = 0;
                var datafinal = $('#datafim').val();
                tratar = datafinal.split("/");
                var datafim = new Date(tratar[2] + "-" + tratar[1] + "-" + tratar[0]);
                if (dataInicial.toString() !== 'Invalid Date' & datafim.toString() !== 'Invalid Date') {
                    if (datafim >= dataInicial) {
                        for (var i = 0; i < datasC.length; i++) {
                            tratar = datasC[i].split("/");
                            if (dataInicial <= new Date(tratar[2] + "-" + tratar[1] + "-" + tratar[0]) &&
                                datafim >= new Date(tratar[2] + "-" + tratar[1] + "-" + tratar[0])) {
                                valorTotal += parseFloat(precos[i]);
                            }

                        }
                        var total = parseFloat(Math.round(valorTotal * 40) / 100).toFixed(2);
                        document.getElementById("valor").value = "Valor: R$ " + total.replace(".", ",");
                        $('#darBaixa').show();
                    } else {
                        document.getElementById("valor").value = "Data Final menor que a inicial";
                        $('#darBaixa').hide();

                    }
                }
            }

            function dataFim(datafim) {
                var tratar = datafim.split("/");
                var dataFinal = new Date(tratar[2] + "-" + tratar[1] + "-" + tratar[0]);
                let valorTotal = new Number();
                var datainicio = $('#datainicio').val();
                tratar = datainicio.split("/");
                var dataInicial = new Date(tratar[2] + "-" + tratar[1] + "-" + tratar[0]);
                if (dataFinal.toString() !== 'Invalid Date' & dataInicial.toString() !== 'Invalid Date') {
                    if (dataFinal >= dataInicial) {
                        for (var i = 0; i < datasC.length; i++) {
                            tratar = datasC[i].split("/");
                            if (dataInicial <= new Date(tratar[2] + "-" + tratar[1] + "-" + tratar[0]) &&
                                dataFinal >= new Date(tratar[2] + "-" + tratar[1] + "-" + tratar[0])) {
                                valorTotal += parseFloat(precos[i]);
                            }
                        }
                        var total = parseFloat(Math.round(valorTotal * 40) / 100).toFixed(2);
                        document.getElementById("valor").value = "Valor: R$ " + total.replace(".", ",");
                        $('#darBaixa').show();
                    } else {
                        document.getElementById("valor").value = "Data Final menor que a inicial";
                        $('#darBaixa').hide();
                    }
                }
            }

            function APagar(precos) {
                var total = 0;
                for (var i = 0; i < precos.length; i++) {
                    total += parseFloat(precos[i]);
                }
                total = parseFloat(Math.round(total * 40) / 100).toFixed(2);
                $('#darBaixa').show();
                return "R$ " + total.replace(".", ",");
            }

            function datas(availableDates) {

                $("#datainicio").datepicker({
                    dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true,
                    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
                    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                    onSelect: function (data) {
                        dataInicio(data);
                    },
                    beforeShowDay: function (d) {
                        var dmy = (d.getMonth() + 1);
                        if (d.getMonth() < 9)
                            dmy = "0" + dmy;
                        dmy += "-";

                        if (d.getDate() < 10) dmy += "0";
                        dmy += d.getDate() + "-" + d.getFullYear();

                        if ($.inArray(dmy, availableDates) != -1) {
                            return [true, "", "Available"];
                        } else {
                            return [false, "", "unAvailable"];
                        }
                    }
                });
                $("#datafim").datepicker({
                    dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true,
                    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
                    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                    onSelect: function (data) {
                        dataFim(data);
                    },
                    beforeShowDay: function (d) {
                        var dmy = (d.getMonth() + 1);
                        if (d.getMonth() < 9)
                            dmy = "0" + dmy;
                        dmy += "-";

                        if (d.getDate() < 10) dmy += "0";
                        dmy += d.getDate() + "-" + d.getFullYear();

                        if ($.inArray(dmy, availableDates) != -1) {
                            return [true, "", "Available"];
                        } else {
                            return [false, "", "unAvailable"];
                        }
                    }
                });
            }
            $('#darBaixa').click(function () {
                var parametros = $('#formBaixa').serialize();
                $.ajax({
                    "url": "{{route('admin.transf.pendentes.darbaixa')}}",
                    "data": parametros,
                    "dataType": "json",
                    "method": "get",
                    "success": function (data) {
                        tabela(localStorage.getItem('pesquisapendente'));
                        $('#myModal').modal('hide');
                        $("#baixaDada").modal('show');
                    }
                });
            });
            function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
            }
            function paginar(max)
            {
                $('#paginas').empty();
                if(getUrlParameter('page') === undefined)
                {
                    var pagina = "<li class='page-item disabled' aria-disabled='true' aria-label='&laquo; Previous'><span class='page-link' aria-hidden='true'>&lsaquo;</span></li>";
                }
                else
                {
                    var pagina = "<li class='page-item" +  (parseInt(getUrlParameter('page')) === 1 ? " disabled" : "") + "' aria-label='&laquo; Previous'><span class='page-link' aria-hidden='true'>&lsaquo;</span></li>";
                }

                for(i = 1; i <= max; i++)
                {
                    if(getUrlParameter('page') === undefined) {
                        pagina += "<li class='page-item'><a class='page-link' id='page"+i+"' href='"+window.location+"?page="+i+"'>"+i+"</a></li>";
                    }
                    else
                    {
                        pagina += "<li class='page-item'><a class='page-link' id='page"+i+"' href='"+window.location.origin + window.location.pathname + "?page="+i+"'>"+i+"</a></li>";
                    }
                }
                    if(getUrlParameter('page') === undefined) {
                        pagina += "<li class='page-item "+ (1 === max ? "disabled" : "") +"'><a class='page-link' href='"+ ((1 !== max) ? window.location +"?page="+2 : "#") +"' rel='next' id='next' aria-label='Next &raquo;'>&rsaquo;</a></li>";
                    }
                    else
                    {
                        var caminho = window.location.origin + window.location.pathname  + "?"+ "page="+(parseInt(getUrlParameter('page')));
                        pagina += "<li class='page-item "+ ((parseInt(getUrlParameter('page')) == max) ? "disabled" : '') + "'>"+
                                    "<a class='page-link' href='"+ ((parseInt(getUrlParameter('page')) != parseInt(max)) ? caminho : "#")+"' rel='next' id='next' aria-label='Next &raquo;'"+
                                    ((parseInt(getUrlParameter('page')) == max) ? " disabled" : '') + "" + ">&rsaquo;</a></li>";
                    }
                $('#paginas').html(pagina).show();
            }
        });

    </script>

    <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom">
        <h1 class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1>
    </div>
    <div class="flex-grid--wrap content__box--first nopadding col-12">
        <div class="flex-grid--wrap halign-center valign-top col-12 pd-10">
            <h2 class="font-20 light mg-10--bottom color-default col mg-20--right">@yield('sectionSubtitle')</h2>
            <form class="form__maquinas form flex-grid--wrap col halign-right is-lg" id='formPesquisa' action="{{ url('/') }}{{ $defaultPath }}"
                method="GET">
                <div class="flex-grid col is-lg"> <input class="input col-12" id="termo" type="text" name="termo" value=""
                        placeholder="Filtrar por campos do tipo Texto" /></div>
            </form>
            <div class="flex-grid col-0 pd-10--bottom is-lg"> <button id='pesquisa' type="submit" class="col-12 btn--second btn-nomargin is-sm"><i
                        class="fa fa-search fa-left"></i> Filtrar</button></div>
        </div>
        <div class="bg-second col-12 color-white pd-10 font-smaller">
            <div class="flex-grid col-0 valign-middle">
                <p style="margin-bottom: 0;"> <strong id="qntRegistros">-</strong> registro(s) encontrado(s)</p>
            </div>
            {{-- {{->total()}} --}}
        </div>
        <table class="table table-striped col-12 responsive-table--lg">
            <thead class="thead">
                <tr class="tr">
                    <th class='th pd-10'>Consultor</th>
                    <th class='th pd-10'>Data Inicio</th>
                    <th class='th pd-10'>Data Fim</th>
                    <th class='th pd-10'>Valor Total</th>
                    <th class='th pd-10'>Comissão</th>
                    <th class='th pd-10'>Qtd. de Atendimentos</th>
                    <th class='th pd-10'>Dar Baixa</th>
                </tr>
            </thead>
            <tbody class="tbody" id="corpoTabela">
            </tbody>
        </table>
        <ul class="pagination-new" id="paginas" role="navigation"></ul>
        <div id='modalAqui'>
            <div class='modal fade' id='myModal' role='dialog'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                            <h4 class='modal-title'><strong>Dados da Baixa</strong></h4>
                        </div>
                        <div class='modal-body'>
                            <form id='formBaixa'>

                                <h5 id='nome'>Nome: </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="datainicio">Data de Início</label>
                                            <input type='text' id='datainicio' class='form-control' name='datainicio' autocomplete='off'>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="datafim">Data de Fim</label>
                                            <input type='text' id='datafim' class='form-control' name='datafim' autocomplete='off'>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id='cd_consultor' name="cd_consultor"/>
                                <input type="text" name="valor" readonly class="form-control-plaintext" style="width: 100%" id='valor'>
                            </form>
                        </div>
                        <div class='modal-footer'>
                            <button style="float: right" class="btn btn-success" id='darBaixa'>Dar baixa</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class='modal fade' id='baixaDada' role='dialog'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4 class='modal-title'><strong>Aviso!</strong></h4>
                        </div>
                        <div class='modal-body'>
                            <h2>Transferência realizada com sucesso!</h2>
                        </div>
                        <div class='modal-footer'>
                            <button data-dismiss='modal' class="btn btn-success">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
