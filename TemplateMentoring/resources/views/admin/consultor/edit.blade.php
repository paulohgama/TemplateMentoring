<?php
$sectionTitle = "Consultor";
$sectionSubtitle = "Alterar Consultor";
$defaultPath = "/admin/especialidade/consultor";
?>
@extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle) @section('title',$sectionSubtitle." - ".$sectionTitle) @section('content')
    <section class="main__content content home flex-grid--wrap col calign-top">
        <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom"><h1
                    class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1></div>
        <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')
            <div class="flex-grid--wrap halign-center valign-top col-12 pd-10">
                <h2 class="font-20 light mg-10--bottom color-default col mg-20--right">@yield('sectionSubtitle')</h2>
                <form class="form__maquinas form flex-grid--wrap col-12 pd-10"
                      action="{{ url('admin/consultor/atualizar/'.$consultores->cd_consultor) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--bottom">* Nome</span>
                        <p class="font-small col-12 color-danger hidden" data-message="Nome"></p>
                        <input type="text" class="input col-12" name="nome" value="{{ $consultores->nm_consultor }}" data-validate="empty" data-name="nome" maxlength="100">
                    </div>

                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--bottom">* CPF</span>
                        <p class="font-small col-12 color-danger hidden" data-message="Nome"></p>
                        <input type="text" class="input col-12" name="cd_cpf" id="cd_cpf" value="{{ $consultores->cd_cpf }}" data-validate="empty" data-name="cpf" placeholder="___.___.___-__">
                    </div>

                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--bottom">Data de nascimento</span>
                        <input type="text" class="input col-12" name="nascimento" id="nascimento" value="@if($consultores->dt_nascimento!=null) {{$consultores->dt_nascimento}}  @endif" data-validate="empty" data-name="Data">
                    </div>

                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--bottom">Sexo</span>
                        <p class="font-small col-12 color-danger hidden" data-message="Nome"></p>
                        <fieldset class="relative mg-10--top mg-10--bottom col-12 radio-fix">
                            <div class="col-12">
                                <label class="radio-inline">
                                    <input type="radio" name="sexo" value="1" data-validate="radio" data-name="Sexo" @if($consultores->ic_sexo=="F") checked @endif> Feminino</label>
                                <label class="radio-inline">
                                    <input type="radio" name="sexo" value="0" data-validate="radio" data-name="Sexo" @if($consultores->ic_sexo=="M") checked @endif> Masculino</label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--bottom">* Email</span>
                        <p class="font-small col-12 color-danger hidden" data-message="Nome"></p>
                        <input id="email" class="input col-12" type="text" name="email" value="{{$usuarios[0]['email']}}" data-validate="empty" data-name="E-mail" placeholder="Seu E-mail" maxlength="100">
                    </div>
                    <input type="hidden" name="id_user" id="id_user" value="{{ $usuarios[0]['cd_usuario'] }}">

                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--bottom">Celular</span>
                        <p class="font-small col-12 color-danger hidden" data-message="Nome"></p>
                        <input type="text" class="input col-12" name="celular" id="celular" value="{{ $consultores->cd_celular }}" data-validate="empty" data-name="Celular" placeholder="(__) _____-____" maxlength="11">
                    </div>

                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--bottom">Estado</span>
                        <p class="font-small col-12 color-danger hidden" data-message="Estado"></p>
                        <select class="input col-12" name="estado" id="estados"></select>
                    </div>
                    <input type="hidden" id="antigosg" value="{{$consultores->sg_estado}}">

                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--bottom">Cidade</span>
                        <p class="font-small col-12 color-danger hidden" data-message="Cidade"></p>
                        <select class="input col-12" name="cidade" id="cidades">
                            <option selected disabled>Primeiro selecione um estado</option>
                        </select>
                    </div>
                    <input type="hidden" id="antigocid" value="{{$consultores->nm_cidade}}">

                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--bottom">Observações</span>
                        <p class="font-small col-12 color-danger hidden" data-message="Observacoes"></p>
                        <input type="text" class="input col-12" name="observacoes" value="{{ $consultores->ds_observacao }}" maxlength="300">
                    </div>


                    <div class="col-12">
                        <span class="font-small bold mg-10--bottom">Especialidades</span>
                        <div class="input">
                            <select id="especialidade" name="especialidade[]" multiple="multiple" class="input col-12">
                                @foreach ($especialidades as $r)
                                    <option value="{{ $r->cd_especialidade }}"
                                            @foreach ($referencia as $item )
                                            @if($item['fk_consultor_especialidade']==$r->cd_especialidade)
                                            selected
                                            @endif
                                            @endforeach
                                    >{{ $r->nm_especialidade }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--bottom">* Status</span>
                        <p class="font-small col-12 color-danger hidden" data-message="Nome"></p>
                        <fieldset class="relative mg-10--top mg-10--bottom col-12 radio-fix">
                            <div class="col-12">
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="1" data-validate="radio" data-name="Status" @if($usuarios[0]->status==1) checked @endif>Ativado</label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="0" data-validate="radio" data-name="Status" @if($usuarios[0]->status==0) checked @endif>Desativado</label>
                            </div>
                        </fieldset>
                    </div>

                    <div class="flex-grid--wrap col-12">
                        <span class="font-small bold mg-10--top mg-10--bottom">* Alterar Foto</span>
                        <p class="font-small col-12 color-danger hidden" data-message="Imagem"></p>
                        <input type="file" class="input col-12" name="foto" value="" data-name="Foto" size="20">
                    </div>

                    <p class="font-small bold mg-10--top mg-10--bottom">Atual</p>

                    <div class="flex-grid--wrap col-12">

                        <img width="140" height="120" style="display:block;" src="/images/especialistas/{{ ($consultores->img_consultor) }}" alt="Não há imagem.">
                    </div>

                    <button type="submit" class="col-0 btn--second btn-nomargin is-sm mg-10--top">
                        <i class="fa fa-download fa-left"></i> Alterar
                    </button>
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script>
            $(document).ready(function () {
                var antigosg = $('#antigosg').val();
                var antigocid = $('#antigocid').val();

                $.getJSON('{{ asset('js/estados_cidades.json') }}', function (data) {
                    var items = [];
                    var options = '<option value="">escolha um estado</option>';
                    $.each(data, function (key, val) {
                        if(val.sigla == antigosg) {
                            options += '<option value="' + val.sigla + '" selected>' + val.nome + '</option>';
                        } else {
                            options += '<option value="' + val.sigla + '">' + val.nome + '</option>';
                        }
                    });
                    $("#estados").html(options);

                    $("#estados").change(function () {

                        var options_cidades = '';
                        var str = "";

                        $("#estados option:selected").each(function () {
                            str += $(this).text();
                        });

                        $.each(data, function (key, val) {
                            if(val.nome == str) {
                                $.each(val.cidades, function (key_city, val_city) {
                                    if(val_city == antigocid) {
                                        options_cidades += '<option value="' + val_city + '" selected>' + val_city + '</option>';
                                    } else {
                                        options_cidades += '<option value="' + val_city + '">' + val_city + '</option>';
                                    }
                                });
                            }
                        });
                        $("#cidades").html(options_cidades);

                    }).change();

                });
                $( "#nascimento" ).datepicker({
                    dateFormat: "dd/mm/yy",
                    maxDate: 0,
                    changeMonth: true,
                    changeYear: true,
                    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
                    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
                });
                // Masked input
                $('#celular').mask('(AA) AAAAA-AAAA');
                $('#cd_cpf').mask('AAA.AAA.AAA-AA');
                $('#especialidade').multiselect({
                    maxHeight: 80,
                    templates: {
                        button: '<button type="button" class="multiselect dropdown-toggle" style="margin-bottom: 10px; padding: 5px;" data-toggle="dropdown"><span class="multiselect-selected-text"></span> <b class="caret"></b></button>',
                        ul: '<ul class="" ></ul>',
                        filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
                        filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default multiselect-clear-filter" type="button"><i class="glyphicon glyphicon-remove-circle"></i></button></span>',
                        li: '<li><a tabindex="0"><label></label></a></li>',
                        divider: '<li class="multiselect-item divider"></li>',
                        liGroup: '<li class=""><label></label></li>'
                    },
                    nonSelectedText: 'Nenhum selecionado',
                    nSelectedText: 'selecionados',
                    allSelectedText: 'Todos selecionados',
                });
            });
        </script>
    </section>
@endsection

