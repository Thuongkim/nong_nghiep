@if ($paginator->lastPage() > 1)
<nav class="tg-pagination">
    <ul>
        @if ($paginator->lastPage() > 1)
            @if ($paginator->currentPage() > 1)
                <li class="tg-prevpage"><a href="{!! $paginator->url($paginator->currentPage() - 1) !!}"><i class="fa fa-angle-left"></i></a></li>
            @endif
            <?php $current = $paginator->currentPage(); $total = $paginator->lastPage(); ?>
            @if($current >= 4)
                <li><a href="{!! $paginator->url(1) !!}">1</a></li>
                <li>...</li>
                @if( $total > $current )
                    <li class="tg-active"><a href="">{!! $current !!}</a></li>
                    <li><a href="{!! $paginator->url($current + 1) !!}">{!! $current + 1 !!}</a></li>
                @else
                    <li><a href="{!! $paginator->url($current - 1) !!}">{!! $current - 1 !!}</a></li>
                    <li class="tg-active"><a href="">{!! $current !!}</a></li>
                @endif
            @else
                @for ($page = 1; $page <= $paginator->lastPage() && $page < 5; $page++)
                    @if ($paginator->currentPage() == $page)
                        <li class="tg-active"><a href="">{!! $page !!}</a></li>
                    @else
                        <li><a href="{!! $paginator->url($page) !!}">{!! $page !!}</a></li></a></li>
                    @endif
                @endfor
            @endif
            @if ($paginator->currentPage() < $paginator->lastPage())
                <li class="tg-nextpage"><a href="{!! $paginator->url($paginator->currentPage() + 1) !!}"><i class="fa fa-angle-right"></i></a></li>
            @endif
        @endif
    </ul>
</nav>
@endif
