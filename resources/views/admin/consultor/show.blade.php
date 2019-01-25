<?php
$sectionTitle = "Consultor";
$sectionSubtitle = "Visualizar Consultor";
$defaultPath = "/admin/consultor/show";
$defaultFilepath = "";
?> @extends('admin.layout.master') @section('sectionTitle',$sectionTitle) @section('sectionSubtitle',$sectionSubtitle) @section('title',$sectionSubtitle." - ".$sectionTitle) @section('content')
    <section class="main__content content home flex-grid--wrap col calign-top">
        <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom"><h1
                    class="col light font-30 main-title is-sm">@yield( 'sectionTitle' )</h1></div>
        <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')<h2
                    class="font-20 light pd-10 color-default col-12">@yield('sectionSubtitle')</h2>
            <form class="form__maquinas form flex-grid--wrap col-12 pd-10" id="formulario_video" action="" method="POST"
                  enctype="multipart/form-data"> {{ csrf_field() }}
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">ID</span>
                    <p class="font-small mg-10--bottom col-12">{{ $consultores->cd_consultor }}</p>
                </div>
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">E-mail</span>
                    <p class="font-small mg-10--bottom col-12">{{ $usuarios[0]->email }}</p>

                </div>
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">Nome</span>
                    <p class="font-small mg-10--bottom col-12">{{ $consultores->nm_consultor }}</p>
                </div>
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">CPF</span>
                    <p class="font-small mg-10--bottom col-12">{{ $consultores->cd_cpf }}</p>
                </div>

                @if(strtotime($consultores->dt_nascimento) > 0)
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">Nascimento</span>
                    <p class="font-small mg-10--bottom col-12">{{ date('d/m/Y', strtotime($consultores->dt_nascimento)) }}</p>
                </div>
                @endif

                @if($consultores->ic_sexo!="")
                    <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">Sexo</span>
                        <p class="font-small mg-10--bottom col-12">{{ $consultores->ic_sexo=="F" ? "Feminino" : "Masculino" }}</p>
                    </div>
                @endif
                @if($consultores->cd_celular!="")
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">Celular</span>
                    <p class="font-small mg-10--bottom col-12">{{ $consultores->cd_celular }}</p>
                </div>
                @endif

                @if($consultores->nm_cidade!="" || $consultores->sg_estado!="")
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">Cidade/Estado</span>
                    <p class="font-small mg-10--bottom col-12">{{ $consultores->nm_cidade }}/{{ $consultores->sg_estado }}</p>
                </div>
                @endif

                @if($consultores->ds_observacao!="")
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">Observação</span>
                    <p class="font-small mg-10--bottom col-12">{{ $consultores->ds_observacao }}</p>
                </div>
                @endif

                @if(count($especialidades) > 0)
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12 ">Especialidades</span>
                    <ul>
                        @foreach($especialidades as $item)
                            <li>{{$item->nm_especialidade}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($consultores->ds_consultor!="")
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">Descrição</span>
                    <p class="font-small mg-10--bottom col-12"><?= nl2br($consultores->ds_consultor) ?></p>
                </div>
                @endif

                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">Status</span>
                    <p class="font-small mg-10--bottom col-12"> {{ $usuarios[0]->status=="1" ? "Ativado" : "Desativado" }}</p>
                </div>
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">Créditos</span>
                    <p class="font-small mg-10--bottom col-12">R$ {{ number_format($consultores->qt_creditos,2) }}</p>
                </div>
                <div class="flex-grid--wrap"><span class="font-small bold mg-10--bottom col-12">Foto</span>
                    <img width="120" height="120" src="/images/especialistas/{{ ($consultores->img_consultor) }}" alt="Não há imagem.">
                </div>
            </form>
        </div>
    </section> @endsection