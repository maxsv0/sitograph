<div class="row module-block" data-id="{$module.name}">
    <input type="hidden" value="{$module.name}" name="module_name[]">

    <div class="col-xs-6 col-sm-4">
        <img src="{$module.preview}" class="img-thumbnail module-preview">
    </div>

    <div class="col-xs-6 col-sm-8">

        <p class="module-price col-xs-2 pull-right text-center">
            {if $module.price}
                <span class="label label-warning">{$module.price}</span>
            {else}
                <span class="label label-success">FREE</span>
            {/if}
        </p>

        <h4 class="module-title">{$module.title}</h4>


        {if $module.tags}
            <p class="module-tags hide">
                Tags:
                {foreach from=$module.tags item=$tag name=loop}
                <a href="{$rep_url}/?tags[]={$tag}" target="_blank">{$tag} <span class="glyphicon glyphicon-new-window"></span></a>{if !$smarty.foreach.loop.last},{/if}
                {/foreach}
            </p>
        {/if}

        <p class="module-description">{$module.description}</p>

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