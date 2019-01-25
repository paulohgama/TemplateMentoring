@extends('site.layouts.master')

@section('meta-title', 'Contato | Tarot Nova Era')
@section('meta-desc', '')

@section('content')
<section id="breadcrumb">
    <div class="container">
        <h1>Contato</h1>
        <ul>
            <li>Você está em</li>
            <li><a href="/">Home</a></li>
            <li><a href="/contato">Contato</a></li>
        </ul>
    </div>
</section>

<section id="contact">
    <div class="container">
        <h2>Fale conosco</h2>
        <p>Fale conosco através do formulário abaixo.</p>
        <div class="row">
            <div class="col-md-9">

                <!--alert-->
                @include('site.includes.msgs')
                <!-- !alert --> 

                <form action="Enviar" method="post" class="default">
                {{csrf_field()}}
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" value="{{old('nome')}}" name="nome" id="nome" placeholder="Ex: Maria Silva" class="form-control" maxlength="100" required>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="email">E-mail: </label>
                                <input type="email" value="{{old('email')}}" class="form-control" id="email" placeholder="maria@gmail.com" name="email" maxlength="100" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telefone">Telefone: </label>
                                <input type="tel2" value="{{old('telefone')}}" class="form-control" id="telefone" data-tel2-mask placeholder="Ex: (11) 00000-0000" name="telefone" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="msg">Mensagem: </label>
                        <textarea name="msg" id="msg" class="form-control" placeholder="Digite aqui a mensagem que deseja nos passar..." maxlength="1500" required>{{old('msg')}}</textarea>
                    </div>
                    <button type="submit">Enviar <span class="spriting centerY sprite-arrow-right"></span></button>
                </form>
            </div>
            <div class="col-md-3">
                <div class="wrap-buttons">
                    <a href="https://wa.me/00000000000/?text=Estou%20interessado(a)%20nos%20serviços%20do%20Tarot%20Nova%20Era." target="_blank" class="btn btn-whats" title="whatsapp">
                        <div class="icon"></div>
                        <div class="text">
                            <span>Fale por</span> Whatsapp
                        </div>
                    </a>
                    <a href="mailto:contato@tarotnovaera.com.br" target="_blank" class="btn btn-email" title="email">
                        <div class="icon"></div>
                        <div class="text">
                            <span>Fale por</span> E-mail
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
<script>
jQuery(function($) {
    $.mask.definitions['~']='[+-]';
    //Inicio Mascara Telefone
    $('input[type=tel2]').focusout(function(){
        var phone, element;
        element = $(this);
        element.unmask();
        phone = element.val().replace(/\D/g, '');
        if(phone.length > 10) {
            element.mask("(99) 99999-999?9");
        } else {
            element.mask("(99) 9999-9999?9");
        }
    }).trigger('focusout');
});
</script>
@endsection