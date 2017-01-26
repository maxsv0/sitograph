{include file="$themePath/widget/header.tpl"}


{if $document}
<div class="container">
	{$document.text}
</div>
{/if}

{if $user.id}
<div class="container">
	{include file="$themePath/user/homepage.tpl"}
</div>
{else}
<div class="container">
<div class="col-sm-6 col-sm-offset-3">
	{include file="$themePath/user/login.tpl"}
</div>
</div>
{/if}



{include file="$themePath/widget/footer.tpl"}