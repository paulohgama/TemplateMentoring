<?php
        $totalPages = isset($_POST['total']) ? $_POST['total'] : 100;
        $currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 50;
        $showPages = isset($_POST['showPages']) ? $_POST['showPages'] : 5;
        $dividerPages = floor($showPages/2);
    ?>
<ul class="pagination flex-grid--wrap col-0 halign-center">
    <?php if($currentPage > 1): ?>
    <li class="pagination__item flex-grid halign-center mg-10--right col-0"><span class="flex-grid valign-middle pagination__link"
            data-page="1"><i class="fa fa-angle-double-left"></i></span></li>
    <li class="pagination__item flex-grid col-0"><span class="flex-grid valign-middle pagination__link" data-page="<?=$currentPage - 1?>"><i
                class="fa fa-angle-left"></i></span></li>
    <?php endif; ?>
    <ul class="pagination__pages flex-grid--wrap halign-center col-0 is-sm">
        <?php for ($i = $currentPage - $dividerPages; $i <= $currentPage + $dividerPages; $i++): ?>
        <?php if ($i > 0 && $i <= $totalPages): ?>
        <li class="pagination__item flex-grid col-0"><span class="pagination__link" data-page="<?=$i?>" <?=$i==$currentPage
                ? 'data-active="true"' : '' ?>></span></li>
        <?php endif; ?>
        <?php endfor; ?>
    </ul>
    <?php if($currentPage < $totalPages): ?>
    <li class="pagination__item flex-grid col-0"><span class="flex-grid valign-middle pagination__link" data-page="<?=$currentPage + 1?>"><i
                class="fa fa-angle-right"></i></span></li>
    <li class="pagination__item flex-grid mg-10--left halign-center col-0"><span class="flex-grid valign-middle pagination__link"
            data-page="<?=$totalPages?>"><i class="fa fa-angle-double-right"></i></span></li>
    <?php endif; ?>
</ul>
