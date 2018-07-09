{include file="$themePath/widget/header.tpl"}

<div class="container top-menu">
	<div class="row">
        {include file="$themePath/widget/menu-top.tpl"}
	</div>
</div>

{include file="$themePath/widget/navigation.tpl"}

<div class="container">
	<div class="row content-block">
		<!-- page document header -->
        {if $document.name}
			<div class="col-sm-12"><h1>{$document.name}</h1></div>
        {/if}
		<!-- page document -->
		<div class="col-sm-12">
            {$document.text}
		</div>
	</div>
</div>


{include file="$themePath/widget/footer.tpl"}