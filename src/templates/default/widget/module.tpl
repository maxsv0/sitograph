<div class="row module-block">

{if $module.preview}
    <div class="col-xs-6 col-sm-4">
        <img src="{CONTENT_URL}/{$module.preview}" class="img-thumbnail module-preview">
    </div>
    <div class="col-xs-6 col-sm-8">
{else}
     <div class="col-xs-12">
{/if}

        <div class="row">
            <div class="col-sm-8">
                <h4 class="module-title">{$module.title} <small>v.{$module.version}</small></h4>

                {if $module.tags}
                    <p class="hide module-tags">
                        Tags:
                        {foreach from=$module.tags item=$tag name=loop}
                        <a href="{$rep_url}/?tags[]={$tag}" target="_blank">{$tag} <span class="glyphicon glyphicon-new-window"></span></a>{if !$smarty.foreach.loop.last},{/if}
                        {/foreach}
                    </p>
                {/if}

                <p class="small module-postdate">
                    Posted <span class="text-muted">{$module.date}</span>
                </p>
            </div>
            <div class="col-sm-4 text-right">
                <p class="module-star-rating">
                    <span class="glyphicon glyphicon-star{if $module.rating < 0.5}-empty{/if}"></span>
                    <span class="glyphicon glyphicon-star{if $module.rating < 1.5}-empty{/if}"></span>
                    <span class="glyphicon glyphicon-star{if $module.rating < 2.5}-empty{/if}"></span>
                    <span class="glyphicon glyphicon-star{if $module.rating < 3.5}-empty{/if}"></span>
                    <span class="glyphicon glyphicon-star{if $module.rating < 4.5}-empty{/if}"></span>
                </p>

                <p class="small module-reviews">Reviews: {$module.reviews}</p>
                <p class="small module-downloads">Downloads: {$module.downloads}</p>
            </div>
        </div>

        <p class="module-price col-xs-2 pull-right text-center">
{if $module.price}
    <span class="label label-warning">{$module.price}</span>
{else}
    <span class="label label-success">FREE</span>
{/if}
        </p>
        <p class="module-description">{$module.description}</p>

        <p class="small text-muted module-buildinfo">
            Date build: {$module.date}, {$module.files|count} files<br>
            {$module.download_url}
        </p>

        <a class="hide module-btnload" href="{$module.download_url}"><span class="glyphicon glyphicon-download-alt"></span> Download {$module.name}.zip</a>
    </div>
</div>
