{include file="$themePath/widget/header.tpl"}

{if $document}
<div class="container">
	{if $document.name}
	<h1>{$document.name}</h1>
	{/if}
	{$document.text}
</div>
{/if}


{include file="$themePath/widget/footer.tpl"}