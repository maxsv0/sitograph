{include file="$themeDefaultPath/widget/header.tpl" themePath=$themeDefaultPath}


<div class="container">
<div class="row">

<div class="col-md-8">

<!-- page document -->
{if $document}
<h1>{$document.name}</h1>
	{$document.text}
{/if}

</div>


<div class="col-md-4">

	<!-- sideblock -->
	{include file="$themeDefaultPath/widget/sideblock.tpl" themePath=$themeDefaultPath}
	
</div>	


</div>	<!-- row -->
</div>	<!-- container -->



{include file="$themeDefaultPath/widget/footer.tpl" themePath=$themeDefaultPath}