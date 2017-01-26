{include file="$themeDefaultPath/widget/header.tpl" themePath=$themeDefaultPath}

{if $document}
<div class="container">
	{if $document.name}
	<h1>{$document.name}</h1>
	{/if}
	{$document.text}
</div>
{/if}


{include file="$themeDefaultPath/widget/footer.tpl" themePath=$themeDefaultPath}