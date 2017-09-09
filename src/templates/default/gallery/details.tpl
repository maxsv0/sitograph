
<p>
    {_t("gallery.posted_by")} {$gallery_album_details.author}, at {$gallery_album_details.date}
</p>
<br />
<p class="text-muted">
    {$gallery_album_details.photos|count} {_t("gallery.photos")},
    {$gallery_album_details.views} {_t("gallery.views")},
    {$gallery_album_details.shares} {_t("gallery.shares")},
    {$gallery_album_details.comments} {_t("gallery.comments")}
</p>
<br />

{if $gallery_album_details.text}
	<p>{$gallery_album_details.text}</p>
{elseif $gallery_album_details.description}
	<p>{$gallery_album_details.description}</p>
{/if}

<div class="row rowItems">
{foreach from=$gallery_album_details['photos'] item=photo} 
<div class="col-lg-4 col-md-6 col-sm-12 rowItem">
<a class="thumbnail" rel="fancybox" href="{$photo.pic}" title="{$photo.description}">
<img src="{$photo.pic_preview}" alt="{$photo.title}">
<span class="thumbnail-overlay">
    <span class="thumbnail-text">
        {$photo.description}
    </span>
</span>
</a>
</div>
{foreachelse} 
<div class="alert alert-info" style="margin-top:20px">{_t("gallery.no_photos")}</div>
{/foreach} 
</div>



<div style="height:100px;"></div>