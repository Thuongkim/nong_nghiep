@if ($paginator->lastPage() > 1)
<div id="paging">
    <div class="auto pagination">
        <ul>
            <?php $current = $paginator->currentPage(); $total = $paginator->lastPage(); ?>
             <!-- If the current page is more than 1, show the First and Previous links -->
            <?php if($paginator->currentPage() > 1) : ?>
                <li class="pagination-prev"><a href="{!! $paginator->url(1) !!}" title="Trang đầu tiên"><i class="fa fa-angle-double-left"></i></a></li>
                <li class="pagination-prev"><a href="{!! $paginator->url($paginator->currentPage() - 1) !!}" title="Trang trước"><i class="fa fa-angle-left"></i></a></li>
            <?php endif; ?>
            <?php
                //setup starting point
                //$max is equal to number of links shown
                $max = 7;
                if($current < $max)
                    $sp = 1;
                elseif($current >= ($total - floor($max / 2)) )
                    $sp = $total - $max + 1;
                elseif($current >= $max)
                    $sp = $current  - floor($max/2);
            ?>
            <!-- If the current page >= $max then show link to 1st page -->
            <?php if($current >= $max) : ?>
                <li><a href="{!! $paginator->url(1) !!}">1</a></li>
                <li>...</li>
            <?php endif; ?>
            <!-- Loop though max number of pages shown and show links either side equal to $max / 2 -->
            <?php for($i = $sp; $i <= ($sp + $max -1);$i++) : ?>
                <?php
                    if($i > $total)
                        continue;
                ?>
                <?php if($current == $i) : ?>
                    <li><a href="javascript:void(0)" class="active">{!! $i !!}</a></li>
                <?php else : ?>
                    <li><a href="{!! $paginator->url($i) !!}">{!! $i !!}</a></li>
                <?php endif; ?>
            <?php endfor; ?>
            <!-- If the current page is less than say the last page minus $max pages divided by 2-->
            <?php if($current < ($total - floor($max / 2))) : ?>
                <li>...</li>
                <li><a href="{!! $paginator->url($total) !!}">{!! $total !!}</a></li>
            <?php endif; ?>
            <!-- Show last two pages if we're not near them -->
            <?php if($current < $total) : ?>
                <li class="pagination-next"><a href="{!! $paginator->url($paginator->currentPage() + 1) !!}" title="Trang cuối cùng"><i class="fa fa-angle-right"></i></a></li>
                <li class="pagination-next"><a href="{!! $paginator->url($paginator->lastPage()) !!}" title="Trang tiếp"><i class="fa fa-angle-double-right"></i></a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
@endif
