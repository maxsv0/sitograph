{if $navigation}

<ol class="breadcrumb">
{section name=index loop=$navigation}
{if !$smarty.section.index.last}
  	<li><a href="{$navigation[index].url}">{$navigation[index].name}</a></li>
{else}
	<li class="active">{$navigation[index].name}</li>
{/if}
{/section}
</ol>

{/if}