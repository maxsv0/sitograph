{if $pagination}

<div class="clearfix">&nbsp;</div>


<nav class="text-center">
  <ul class="pagination">
    
{if $pagination.prev}
<li><a href="{$pagination.prev.url}{$urlsuffix}" aria-label="{_t("btn.previous")}"><span aria-hidden="true">&laquo;</span></a></li>
{else}
<li class="disabled"><a href="#" aria-label="{_t("btn.previous")}"><span aria-hidden="true">&laquo;</span></a></li>
{/if}
    

{foreach from=$pagination.pages key=album_id item=page}
{if $pagination.current.page === $page.page}
<li class="active"><a href="{$page.url}{$urlsuffix}">{$page.name}</a></li>
{else}
<li><a href="{$page.url}{$urlsuffix}">{$page.name}</a></li>
{/if}
{/foreach} 

{if $pagination.next}
<li><a href="{$pagination.next.url}{$urlsuffix}" aria-label="{_t("btn.next")}"><span aria-hidden="true">&raquo;</span></a></li>
{else}
<li class="disabled"><a href="#" aria-label="{_t("btn.next")}"><span aria-hidden="true">&raquo;</span></a></li>
{/if}

  </ul>
</nav>
{/if}