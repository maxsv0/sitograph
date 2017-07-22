{if $admin_edit}


    {include "$themePath/sitograph/form-table.tpl" dataList=$admin_edit}


{else}


    {include "$themePath/sitograph/list-table.tpl" listTable=$admin_list}



{/if}



