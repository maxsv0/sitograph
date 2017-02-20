
{foreach from=$gallery_albums key=album_id item=album} 

<div class="col-sm-4 rowItem">
{include "$themePath/gallery/album-list.tpl"}
</div>


{foreachelse}
<div class="col-sm-6 col-md-offset-2">
<div class="well">No photos was found.</div>
</div>
{/foreach} 



{assign var="pagination" value=$gallery_pages}
{include file="$themePath/widget/pagination.tpl"}



