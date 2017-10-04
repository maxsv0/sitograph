{include "$themePath/sitograph/form-table.tpl"  dataList=$admin_edit_structure}

<div class="clearfix">&nbsp;</div>

{if $admin_edit_structure.page_document_id}
<div class="col-sm-6">
{if $admin_edit_structure.page_document_id}
<a href="{$lang_url}/admin/?section=structure&edit={$admin_edit_structure.id}#document" title="{$t['document_edit']}" class="btn btn-primary">{$t['btn.document_edit']} <span class="glyphicon glyphicon-edit"></span></a>
{else}
<a href="{$lang_url}/admin/?section=structure&document_create={$admin_edit_structure.id}" title="{$t['document_create']}" class="btn btn-warning">{$t['btn.document_create']} <span class="glyphicon glyphicon-ok"></span></a>
{/if}
</div>
{/if}