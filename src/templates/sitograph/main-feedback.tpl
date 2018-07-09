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
            <div class="col-sm-12"><h1>{$document.name}</h1></div>
        {/if}
        <div class="col-sm-5">
            {$document.text}
        </div>
        <div class="col-sm-7">
            {include file="$themePath/widget/messages.tpl"}

            {include file="$themePath/feedback/main.tpl"}
        </div>
    </div>
</div>


{include file="$themePath/widget/footer.tpl"}