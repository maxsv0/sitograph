{include "$themePath/admin/form-table.tpl"  dataList=$admin_edit_structure}


{if $admin_edit_structure.page_document_id}
<a href="/admin/?section=structure&edit={$admin_edit_structure.id}#document" title="{$t['document_edit']}" class="btn btn-primary btn-xs">{$t['btn.document_edit']} <span class="glyphicon glyphicon-edit"></span></a>
{else}
<a href="/admin/?section=structure&document_create={$admin_edit_structure.id}" title="{$t['document_create']}" class="btn btn-warning btn-xs">{$t['btn.document_create']} <span class="glyphicon glyphicon-ok"></span></a>
{/if}
