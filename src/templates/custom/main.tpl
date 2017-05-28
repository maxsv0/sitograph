{include file="$themeDefaultPath/widget/header.tpl" themePath=$themeDefaultPath}

<div class="container top-menu">
	<div class="row">
		{include file="$themeDefaultPath/widget/menu-top.tpl"}
	</div>
</div>

{include file="$themeDefaultPath/widget/navigation.tpl"}

<div class="container">
	<div class="row content-block">

	<div class="col-lg-12">
{if $document.name}
	<h1>{$document.name}</h1>
{/if}
	{$document.text}
	</div>
</div>
</div>
 

{include file="$themeDefaultPath/widget/footer.tpl" themePath=$themeDefaultPath}}