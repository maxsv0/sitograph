{if $admin_edit}


{assign var="list_edit" value="$themePath/admin-mcg/$admin_section/edit_$admin_table.tpl"}

{if file_exists($list_edit)}
	{include "$list_edit"}
{else}
	{include "$themePath/admin-mcg/custom/edit.tpl"}
{/if}
    
    

{else}


{assign var="list_custom" value="$themePath/admin-mcg/$admin_section/list_$admin_table.tpl"}

{if file_exists($list_custom)}
	{include "$list_custom"}
{else}
	{include "$themePath/admin-mcg/custom/list.tpl"}
{/if}
	


{/if}

