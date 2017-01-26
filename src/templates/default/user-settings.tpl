{include file="$themePath/widget/header.tpl"}


{if $document}
<div class="container">
	{$document.text}
</div>
{/if}

<div class="container">
	{include file="$themePath/user/settings.tpl"}
</div>

{include file="$themePath/widget/footer.tpl"}