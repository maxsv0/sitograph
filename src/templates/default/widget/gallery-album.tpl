<div class="row media-well">
    {if $album.title}
        <h3 class="col-xs-12">
            {_t("blog.attached_gallery")} <a href="{$gallery.baseUrl}{$album.url}/">{$album.title}</a>
            <small>({$album.photos|count} photos)</small>
        </h3>
    {/if}
{foreach from=$album.photos item=photo name=loop}
    <div class="col-xs-6 col-sm-4">
        <a class="thumbnail thumbnail-hover" rel="fancybox" title="{$photo.description}" href="{$photo.pic}">
            <img src="{$photo.pic_preview}" alt="{$photo.title}">
            <span class="thumbnail-overlay">
                <span class="thumbnail-text">{$photo.title}</span>
            </span>
        </a>
    </div>
{/foreach}
</div>