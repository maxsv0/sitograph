{include file="$themePath/widget/header.tpl"}


{if $document}
<div class="container">
	{$document.text}
</div>
{/if}

<div class="container">
<div class="col-sm-6 col-sm-offset-3">
	{include file="$themePath/user/user-password-reset.tpl"}
</div>
</div>

{include file="$themePath/widget/footer.tpl"}