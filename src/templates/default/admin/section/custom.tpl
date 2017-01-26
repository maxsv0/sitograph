{if $admin_edit}


{assign var="list_edit" value="$themePath/admin/$admin_section/edit_$admin_table.tpl"}

{if file_exists($list_edit)}
	{include "$list_edit"}
{else}
	{include "$themePath/admin/custom/edit.tpl"}
{/if}
    
    

{else}


{assign var="list_custom" value="$themePath/admin/$admin_section/list_$admin_table.tpl"}

{if file_exists($list_custom)}
	{include "$list_custom"}
{else}
	{include "$themePath/admin/custom/list.tpl"}
{/if}
	


{/if}

