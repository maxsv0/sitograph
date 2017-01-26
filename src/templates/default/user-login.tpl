{include file="$themePath/widget/header.tpl"}


{if $document}
<div class="container">
	{$document.text}
</div>
{/if}


<div class="container">
<div class="col-sm-6 col-sm-offset-2">
	{include file="$themePath/user/login.tpl"}
</div>
</div>


{include file="$themePath/widget/footer.tpl"}