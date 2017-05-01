{include file="$themePath/widget/header.tpl"}

<div class="container top-menu">
	<div class="row">
		{include file="$themePath/widget/menu-top.tpl"}
	</div>
</div>

{include file="$themePath/widget/navigation.tpl"}	

<div class="container">
  	<div class="row content-block">
    {if $gallery_album_details.title}
    <div class="col-xs-12 album-title-block"><h1>{$gallery_album_details.title}</h1></div>
    {elseif $page.name}
    <div class="col-xs-12 album-title-block"><h1>{$page.name}</h1></div>
    {/if}
    
    <div class="col-xs-12">
    	{if $document.text}{$document.text}<br />{/if}
        {include file="$themePath/gallery/main.tpl"} 
    </div>
	</div>
</div>


{include file="$themePath/widget/footer.tpl"}