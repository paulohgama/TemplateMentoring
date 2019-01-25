<header id="main-header">
    <div class="container">
        <h2>Suas respostas <br> através dos oráculos</h2>
        <h1>Cartas ciganas, tarot, <br> búzios, runas</h1>
        @php
            $valor = \App\Valor::orderBy('cd_valor', 'desc')->first();
        @endphp
        <h3>Por apenas R$ {{ number_format($valor->valor, 2, ',', '') }}/min</h3>
        <div class="btn-wrap">
        <a href="{{url('/comprar-minutos')}}" class="btn-default">
                <div class="wrap">
                    <span class="spriting sprite-hand-coin"></span>
                    compre créditos
                </div>
            </a>
        </div>
        <div id="go-down" title="rolar para baixo"><span class="spriting sprite-arrow-down"></span></div>
    </div>
</header>
