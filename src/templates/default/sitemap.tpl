{include file="$themePath/widget/header.tpl"}

<div class="container top-menu">
    <div class="row">
        {include file="$themePath/widget/menu-top.tpl"}
    </div>
</div>

{include file="$themePath/widget/navigation.tpl"}

<div class="container">
    <div class="row content-block">

        {if $document.name}
            <div class="col-lg-12"><h1>{$document.name}</h1></div>
        {/if}

        <div class="col-lg-8 col-md-7 col-sm-12">
            {$document.text}

            {foreach from=$structure name=loop item=item}
                {if $item.sitemap > 0}
                    {if $item.parent_id == 0}
                        <h3><a href="{$item.url}">{$item.name}</a></h3>
                        <ul>
                            {foreach from=$structure name=loop2 item=item2}
                                {if $item.id == $item2.parent_id}
                                    <li><a href="{$item2.url}">{$item2.name}</a></li>
                                {/if}
                            {/foreach}
                        </ul>
                    {/if}
                {/if}
            {/foreach}
        </div>
        <div class="col-lg-4 col-md-5 hidden-sm">
            {include file="$themePath/widget/sideblock.tpl"}
        </div>
    </div>
</div>


{include file="$themePath/widget/footer.tpl"}