
@extends('admin.layout.clear') @section('title', 'Login') 

@section('content')
<main class="flex-grid--col col-12 login">
    <section class="flex-grid login__section col valign-middle halign-center pd-50--top pd-50--bottom">
        <div class="login__box">
            <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')</div>
            <form class="flex-grid--wrap login__form form shadow pd-20" action="{{ route('admin.login') }}" method="post">
                {{ csrf_field() }}<figure class="flex-grid form__box login__figure"> <img class="login__img logo_adm"
                        src="{{ url('/images/logo-admin-colorfull.png') }}"></img></figure>
                <div class="flex-grid--wrap form__box col-12"><span class="color-danger hidden col-12" data-message="E-mail"></span>
                    <input id="email" class="input--default input-nomargin col" type="text" name="email" data-validate="empty:email"
                        data-name="E-mail" placeholder="E-mail ou Login" /></div>
                <div class="flex-grid--wrap form__box col-12"><span class="color-danger hidden col-12" data-message="Senha"></span>
                    <div class="flex-grid box-password col mg-10--bottom valign-top"> <input id="password" class="input--default input-nomargin box-password__input col"
                            type="password" name="password" data-validate="empty" data-name="Senha" placeholder="Senha" /><i
                            class="fa fa-eye box-password__show color-default"></i></div>
                </div>
                <div class="flex-grid form__box col-0 halign-right is-xs"> <button class="btn--first btn-noradius self-top col"
                        type="submit" /> Entrar<i class="fa fa-long-arrow-right fa-right"></i></button></div>
                <div class="flex-grid--wrap col-12">
                    <p class="text color-default col-12"> <a href="{{ url('/admin/esqueceu-sua-senha') }}" class="link--first">Esqueceu
                            sua senha?</a></p>
                </div>
            </form>
        </div>
    </section>
    <footer class="footer flex-grid halign-center pd-20">
        <p class="text-center font-small color-white"> <a class="link--white" href="http://www.kbrtec.com.br" target="_blank">©
                Kbrtec</a> - Todos os direitos reservados</p>
    </footer>
</main> @endsection @section('css')<style type="text/css">
    .logo_adm {
        height: 80px;
        width: 80px;
        margin: 0 auto;
        border-radius: 50%;
        object-fit: cover;
    }

</style> @endsection
