{include file="$themePath/widget/header.tpl"}


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
	{include file="$themePath/widget/sideblock.tpl"}
	
</div>	


</div>	<!-- row -->
</div>	<!-- container -->



{include file="$themePath/widget/footer.tpl"}
