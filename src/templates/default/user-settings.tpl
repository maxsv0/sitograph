{include file="$themePath/widget/header.tpl"}

<div class="container top-menu">
	<div class="row">
		{include file="$themePath/widget/menu-top.tpl"}
	</div>
</div>

{include file="$themePath/widget/navigation.tpl"}

<div class="container">
	<div class="row content-block">

    <div class="col-md-12">
    	{if $document.name}
	    <h1>{$document.name}</h1>
	    {/if}
	    
    	{if $document}
    		{$document.text}<br />
    	{/if}
    	
    	{include file="$themePath/widget/messages.tpl"}
    	
        {include file="$themePath/user/settings.tpl"}
    </div>
    
	</div>
</div>


{include file="$themePath/widget/footer.tpl"}