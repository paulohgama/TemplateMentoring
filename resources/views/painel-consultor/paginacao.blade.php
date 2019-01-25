@if ($paginator->lastPage() > 1)
    <ul>
        <li class="prev {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"><a href="{{ $paginator->url($paginator->currentPage()-1) }}">Anterior</a></li>
        @if($paginator->currentPage() < 7)
            @if($paginator->lastPage() > 11)
                @for ($i = 1; $i <= 11; $i++)
                    <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                        <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
            @else
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                        <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
            @endif
        @elseif($paginator->currentPage()+5 > $paginator->lastPage())
            @if($paginator->lastPage() >= 11)
                @for ($i = $paginator->lastPage()-10; $i <= $paginator->lastPage(); $i++)
                    <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                        <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
            @else
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                        <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
            @endif
        @else
            @for ($i = $paginator->currentPage()-5; $i <= $paginator->currentPage()+5; $i++)
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{$i}}</a>
                </li>
            @endfor
        @endif
        <li class="next {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}"><a href="{{ $paginator->url($paginator->currentPage()+1) }}">Próximo</a></li>
    </ul>
@endif