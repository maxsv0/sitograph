
{foreach from=$gallery_albums key=album_id item=album} 

<div class="col-sm-4 rowItem">
{include "$themePath/gallery/album-list.tpl"}
</div>


{foreachelse}

<div class="alert alert-info">{_t('gallery.search_no_result')}</div>


{/foreach} 



{assign var="pagination" value=$gallery_pages}
{include file="$themePath/widget/pagination.tpl"}
