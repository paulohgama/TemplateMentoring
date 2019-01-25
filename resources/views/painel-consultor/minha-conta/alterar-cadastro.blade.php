@extends('painel-consultor.layouts.master')

@section('meta-title', 'Alterar Cadastro - Painel Consultor | Tarot Nova Era')
@section('meta-desc', '')

@section('meta-desc', '')

@section('breadcrumb')
<ul class="breadcrumb-list">
    <li>Você está em</li>
    <li>Home</li>
    <li>Alterar Cadastro</li>
</ul>
@endsection

@section('content')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    
<section id="minha-conta"> 
    <div class="wrap-rounded-column">
        <div class="form-box cad">
            @include('site.includes.msgs')
            <h2 class="title">Alterar Cadastro</h2>
            <form action="{{route('altera.cadastro')}}" method="post" class="default" enctype="multipart/form-data">
            @csrf
                <div class="row divisor">
                    <div class="col-md-6">    
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" class="form-control" value="{{ $consultores->nm_consultor }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">E-mail <span>(será usado como login)</span></label>
                            <input type="email" id="email" name="email" class="form-control" required value="{{$usuarios[0]['email']}}">
                        </div>
                    </div>
                </div>    
                <div class="row divisor">
                    <div class="col-md-3">    
                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="text" id="cpf" name="cpf" data-cpf-mask class="form-control" value="{{ $consultores->cd_cpf }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nascimento">Data de Nascimento</label>
                            <input type="text" id="nascimento" name="nascimento" data-date-mask class="form-control" value="@if(strtotime($consultores->dt_nascimento)) {{$consultores->dt_nascimento}}  @endif">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="radio-wrapper">
                                <label for="sexo">Sexo</label>
                                <div class="box-options">
                                    <div class="radio-item">
                                        <input type="radio" id="sexo" name="sexo" value="M" @if($consultores->ic_sexo=="M") checked @endif>
                                        <div class="btn">Masculino</div>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" id="sexo" name="sexo" value="F" @if($consultores->ic_sexo=="F") checked @endif>
                                        <div class="btn">Feminino</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row divisor">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="celular">Celular</label>
                            <input type="tel" id="celular" name="celular" data-cel-mask class="form-control" value="{{$consultores->cd_celular}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estados" class="form-control"></select>
                            <input type="hidden" id="antigosg" value="{{$consultores->sg_estado}}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <select name="cidade" id="cidades" class="form-control"></select>
                            <input type="hidden" id="antigocid" value="{{$consultores->nm_cidade}}">
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-3">
                        <div class="upload-img">
                            <figure>
                                <img src="/images/especialistas/{{ ($consultores->img_consultor) }}" id="frame-view" class="img-fluid" alt="">
                            </figure>
                            <h4>Alterar foto?</h4>
                            <div class="wrap-file">
                                <input type="file" name="foto" id="img-input" accept="image/png, image/jpeg">
                                <div class="btn-file">Escolher arquivo</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="especialidade">Especialidades</label>
                                    <select name="especialidade[]" id="especialidade" multiple="multiple">
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
                        </div>
                        <div class="form-group">
                            <label for="dsc">Descrição</label>
                            <textarea name="dsc" id="dsc" class="form-control">{{($consultores->ds_consultor == null)? '' : $consultores->ds_consultor}}</textarea>
                        </div>
                        <button type="submit" class="mt-3">Alterar</button>
                    </div>
                </div>
            </form>
        </div> 
    </div>
    <script type="text/javascript" src="{{ asset('js/ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript">
	CKEDITOR.replace( 'dsc', {
		language: 'pt-br',
        toolbar: [
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
            { name: 'links' , items: [ 'Link', 'Unlink' ]}
	    ]
    });
	</script>
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
                    changeMonth: true,
                    changeYear: true,
                    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
                    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
                });
                $('#especialidade').multiselect({
                    maxHeight: 150,
                    templates: {
                        button: '',
                        ul: '<ul class=""></ul>',
                        filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
                        filterClearBtn: '<span class="input-group-btn"><button class=" multiselect-clear-filter" type="button"><i class="glyphicon glyphicon-remove-circle"></i></button></span>',
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