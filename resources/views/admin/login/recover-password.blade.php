@extends('admin.layout.clear') @section('title', 'Esqueceu sua senha') @section('content')<main class="flex-grid--col col-12 login"><section class="flex-grid login__section col valign-middle halign-center pd-50--top pd-50--bottom"><div class="login__box"><div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')</div><form class="flex-grid--wrap login__form form shadow pd-20" action="{{ url('/admin/esqueceu-sua-senha') }}" method="post"> {{ csrf_field() }}<figure class="flex-grid form__box login__figure"> <img class="login__img" src="{{ url('/images/default/logo-oab-praiagrande.svg') }}"></img></figure><div class="flex-grid--wrap form__box col-12"><span class="color-danger hidden col-12" data-message="E-mail"></span> <input id="email" class="input--default input-nomargin col" type="text" name="email" data-validate="empty:email" data-name="E-mail" placeholder="E-mail"/></div><div class="flex-grid form__box col-0 halign-right is-xs"> <button class="btn--first btn-noradius self-top col" type="submit"/> Enviar</button></div></form></div></section><footer class="footer flex-grid halign-center pd-20"><p class="text-center font-small color-white"> <a class="link--white" href="http://www.kbrtec.com.br" target="_blank">© Kbrtec</a> - Todos os direitos reservados</p></footer></main> @endsection