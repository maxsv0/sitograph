{if $admin_edit && $add}

        {include "$themePath/sitograph/locates/add.tpl"}
        
{elseif $itemField && $edit}


    {include "$themePath/sitograph/locates/edit.tpl"}



{else}


	{include "$themePath/sitograph/locates/list.tpl"}


{/if}
