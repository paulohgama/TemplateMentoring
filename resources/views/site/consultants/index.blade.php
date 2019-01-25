@extends('site.layouts.master')

@section('meta-title', 'Consultores | Tarot Nova Era')
@section('meta-desc', '')

@section('content')
<section id="breadcrumb">
    <div class="container">
        <h1>Consultores</h1>
        <ul>
            <li>Você está em</li>
            <li><a href="/">Home</a></li>
            <li><a href="/consultores">Consultores</a></li>
        </ul>
    </div>
</section>

<section id="consultants" class="inside">
    <div class="container">

        <div class="search-wrap">
            <form action="" method="get">
                <div class="wrap-input">
                    <input type="text" placeholder="Buscar" name="termo">
                    <button type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div> 
        @php
        $cfiltered = [];
        foreach ($consultores as $c) {
            $cfiltered[] = $c;
        }
        @endphp
      
        <consultant-list :consultores="{{ json_encode($cfiltered) }}"></consultant-list>
        
        <div id="paginator">
            {{$consultores->links('painel-consultor.paginacao')}}
        </div>
    </div>
</section>
@endsection