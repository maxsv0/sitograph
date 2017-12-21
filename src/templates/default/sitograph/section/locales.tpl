{if $admin_edit && $add}

    {include "$themePath/sitograph/locates/add.tpl"}


{elseif $admin_edit && $edit}


    {include "$themePath/sitograph/locates/edit.tpl"}



{else}


	{include "$themePath/sitograph/locates/list.tpl"}


{/if}
