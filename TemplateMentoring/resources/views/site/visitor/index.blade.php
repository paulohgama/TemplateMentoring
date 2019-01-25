@extends('site.layouts.master')

@section('meta-title', 'Painel Visitante | Tarot Nova Era')
@section('meta-desc', '')

@section('content')
<section id="breadcrumb">
    <div class="container">
        <h1>Painel Visitante</h1>
        <ul>
            <li>Você está em</li>
            <li><a href="/">Home</a></li>
            <li><a href="/">Painel Visitante</a></li>
        </ul>
    </div>
</section>

<section id="buy-minutes">
    <div class="container">
        <div class="title-box">
            <div class="icon car"></div>
            <p><span>Compre Creditos</span> para fazer suas consultas no Tarot Nova Era.</p>
        </div>
        <!-- form -->
        <div class="buy-time-block">
            <form action="" method="post">
                <!-- price prop is the price value per minute. --> 
                <buy-minute-counter :price="1"></buy-minute-counter>

                <div class="btn-box">
                    <span class="spriting sprite-long-arrow-left"></span>
                    <button type="submit"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Prosseguir com a compra</button>
                    <span class="spriting sprite-long-arrow-right"></span>
                </div>
                <div class="block-adverter">
                    <img src="/images/pagseguro-small.png" alt="">
                    <p>Você será direcionado para o pagseguro</p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection