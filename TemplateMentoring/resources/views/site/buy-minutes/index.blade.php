@extends('site.layouts.master')

@section('meta-title', 'Comprar Minutos | Tarot Nova Era')
@section('meta-desc', '')

@section('content')
<section id="breadcrumb">
    <div class="container">
        <h1>Comprar Minutos</h1>
        <ul>
            <li>Você está em</li>
            <li><a href="/">Home</a></li>
            <li><a href="/comprar-minutos">Comprar Minutos</a></li>
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
        <form action="{{route('pagamento.finalizar')}}" method="post">
                @csrf
                <!-- price prop is the price value per minute. -->
                <buy-minute-counter :price="{{$val}}"></buy-minute-counter>

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
<div class='modal fade' id='erro' role='dialog'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title'><strong>Aviso!</strong></h4>
                </div>
                <div class='modal-body'>
                    <h5>Escolha 1 minuto ou mais para prosseguir com a compra</h5>
                </div>
                <div class='modal-footer'>
                    <button data-dismiss='modal' class="btn btn-success">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@if (session()->has('creditozero'))
    <script>
        $("#erro").modal('show');
    </script>
@endif
@endsection
