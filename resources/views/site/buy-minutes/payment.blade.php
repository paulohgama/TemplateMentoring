@extends('site.layouts.master')

@section('meta-title', 'Pagamento | Tarot Nova Era')
@section('meta-desc', '')

@section('content')
<section id="breadcrumb">
    <div class="container">
        <h1>Pagamento</h1>
        <ul>
            <li>Você está em</li>
            <li><a href="/">Home</a></li>
            <li><a href="/pagamento">Pagamento</a></li>
        </ul>
    </div>
</section>
@php
    $valor = session()->get('valor');
    $preco = session()->get('preco');
    $minutos = session()->get('minutos');

@endphp
@if($valor == '')
    <script>window.location='/comprar-minutos';</script>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $.ajax({
            "url": "{{route('pegar.token')}}",
            "method": "post",
            "dataType": "json",
            "data": {
                valor: {{str_replace(",", ".", $valor)}},
                preco: {{str_replace(",", ".", $preco)}},
                minutos: {{$minutos}},
                visitante: {{Auth::user()->cd_usuario_fk}},
                _token: "{{csrf_token()}}"
            },
            "success": function(data)
            {
                $("#code").val(data.code[0]);
            }
        });
</script>
<section id="buy-minutes">
    <div class="container">
        <div class="title-box">
            <div class="icon coin"></div>
            <p><span>Pagamento</span> resumo da compra</p>
        </div>
        <!-- form -->
        <div class="buy-time-block">
            <form action="https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html" method="get">
                <div class="row">
                    <div class="col-md-4">
                        <div class="wrap-content price">
                            <div class="spriting sprite-clock-rounded"></div>
                            <div class="text">
                                <h6>Quantidade em min/</h6>
                                <span class="price">{{$minutos}}</span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="code" name="code" value="">
                    <div class="col-md-4">
                        <div class="wrap-content price">
                            <div class="spriting sprite-coin-rounded"></div>
                            <div class="text">
                                <h6>Valor por min/</h6>
                                <span class="price">R$ {{$valor}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="wrap-content price">
                            <div class="spriting sprite-coin-rounded"></div>
                            <div class="text">
                                <h6>Valor Total</h6>
                                <span class="price">R$ {{$preco}}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="block-adverter mt-5">
                    <img src="/images/pagseguro-small.png" alt="">
                    <p>Você será direcionado para o pagseguro</p>
                </div>

                <div class="btn-box">
                    <span class="spriting sprite-long-arrow-left"></span>
                    <button type="submit" id="pagamento">Pagar</button>
                    <span class="spriting sprite-long-arrow-right"></span>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection
