{if $admin_edit && $add}

        {include "$themePath/admin-mcg/locates/add.tpl"}
        
{elseif $itemField && $edit}


    {include "$themePath/admin-mcg/locates/edit.tpl"}



{else}


	{include "$themePath/admin-mcg/locates/list.tpl"}


{/if}
