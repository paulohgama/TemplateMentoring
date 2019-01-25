<?php
    $sectionTitle = "Transferencias";
    $sectionSubtitle = "Realizadas";
    $defaultPath = "/admin/transferencias/realizadas/";
    $defaultFilepath = "";
?>
@extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle)
@section('title',$sectionTitle." ".$sectionSubtitle) @section('content')
<section class="main__content content home flex-grid--wrap col calign-top">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



    <script type="text/javascript">
        $(document).ready(function () {

            var availableDates = [];
            var datasC = [];
            var precos = [];
            $.noConflict();
            $('#termo').val(localStorage.getItem('pesquisareal'));
            tabela(localStorage.getItem('pesquisareal'));
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
                localStorage.setItem('pesquisareal', parametros[0].value);
            }
            function tabela(pesquisa){
                $.ajax({
                    "url": "{{route('admin.transf.realizados')}}",
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
                            if(i < dados.length-1){
                                var linhaRegistro = "<tr>";
                                var total = parseFloat(Math.round(linha.total * 100) / 100).toFixed(
                                    2);
                                var comissao = parseFloat(Math.round(linha.comissao * 100) / 100).toFixed(
                                    2);
                                linhaRegistro += "<td class='th pd-10 text-center'>" + linha.id +
                                    "</td>";
                                linhaRegistro += "<td class='th pd-10 text-center'>" + linha.nome +
                                    "</td>";
                                linhaRegistro += "<td class='th pd-10 text-center'>" + linha.pagamento +
                                    "</td>";
                                linhaRegistro += "<td class='th pd-10 text-center'>" + linha.periodo +
                                    "</td>";
                                linhaRegistro += "<td class='th pd-10 text-center'>" + linha.atendimentos +
                                    "</td>";
                                linhaRegistro += "<td class='th pd-10 text-center'>R$ " + total.replace(
                                    ".", ",") + "</td>";
                                linhaRegistro += "<td class='th pd-10 text-center'>R$ " + comissao.replace(
                                    ".", ",") + "</td>";
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
                <div class="flex-grid col is-lg"> <input class="input col-12" type="text" id="termo" name="termo" value=""
                        placeholder="Filtrar por campos do tipo Texto" /></div>
            </form>
            <div class="flex-grid col-0 pd-10--bottom is-lg"> <button id='pesquisa' type="submit" class="col-12 btn--second btn-nomargin is-sm"><i
                        class="fa fa-search fa-left"></i> Filtrar</button></div>
        </div>
        <div class="bg-second col-12 color-white pd-10 font-smaller">
            <div class="flex-grid col-0 valign-middle">
                <p> <strong id="qntRegistros">-</strong> registro(s) encontrado(s)</p>
            </div>
        </div>
        <table class="table table-striped col-12 responsive-table--lg">
            <thead class="thead">
                <tr class="tr">
                    <th class='th pd-10 text-center' style="width: 5%">#</th>
                    <th class='th pd-10 text-center'>Consultor</th>
                    <th class='th pd-10 text-center'>Data/Hora Pagamento</th>
                    <th class='th pd-10 text-center'>Periodo de Atendimento</th>
                    <th class='th pd-10 text-center'>Qtd. de Atendimentos</th>
                    <th class='th pd-10 text-center'>Valor Total</th>
                    <th class='th pd-10 text-center'>Comissão</th>
                </tr>
            </thead>
            <tbody class="tbody" id="corpoTabela">
            </tbody>
        </table>
        <ul class="pagination" id="paginas" role="navigation">



        </ul>

    </div>
</section> @endsection
