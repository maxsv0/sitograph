<div class="row module-block" data-id="{$module.id}">
<input type="hidden" value="{$module.name}" name="module_name[]">

{if $module.preview}
    <div class="col-xs-6 col-sm-4">
        <img src="{$module.preview}" class="img-thumbnail module-preview">
    </div>
    <div class="col-xs-6 col-sm-8">
{else}
     <div class="col-xs-12">
{/if}

        <div class="row">
            <div class="col-sm-8">
                <h4 class="module-title">{$module.title}</h4>

                {if $module.tags}
                    <p class="hide module-tags">
                        Tags:
                        {foreach from=$module.tags item=$tag name=loop}
                        <a href="{$rep_url}/?tags[]={$tag}" target="_blank">{$tag} <span class="glyphicon glyphicon-new-window"></span></a>{if !$smarty.foreach.loop.last},{/if}
                        {/foreach}
                    </p>
                {/if}

                <p class="small module-postdate">
                    {$module.name} v.{$module.version} <span class="text-muted">posted</span> {$module.date}
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
            Date build: {$module.date}<br>
        </p>
        <p class="hide module-btnpage">
           {$rep_url}/module/{$module.name}/
        </p>
        <p class="hide module-buildfiles">
            {$module.files|count} files:<br>
            {foreach from=$module.files item=$file name=loop}
                {if $file.dir != "abs"}{$file.dir}{/if}/{$file.path}<br>
            {/foreach}
        </p>

        <a class="hide module-btnload" href="{$module.download_url}"><span class="glyphicon glyphicon-download-alt"></span> Download {$module.name}.zip</a>
    </div>
</div>