{assign var="listTable" value=$admin_list}

{if $listTable}
<div class="table-responsive">
<table class="table table-hover table-striped table-module">
<th>{$t["actions"]}</th>
<th>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=id&sortd={$table_sortd_rev}">{$t["table.documents.id"]}</a>
{if $table_sort == "id"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=name&sortd={$table_sortd_rev}">{$t["table.documents.name"]}</a>
{if $table_sort == "name"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=external_link&sortd={$table_sortd_rev}">{$t["table.documents.external_link"]}</a>
{if $table_sort == "external_link"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=updated&sortd={$table_sortd_rev}">{$t["table.documents.updated"]}</a>
{if $table_sort == "updated"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>

{foreach from=$listTable name=loop key=item_id item=item}
{if $item.published}
<tr>
{else}
<tr class="danger">
{/if}
<td class="text-nowrap">
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&edit={$item.id}#document" title="{$t['btn.edit']}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&duplicate={$item.id}" title="{$t['btn.duplicate']}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-duplicate"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&delete={$item.id}" title="{$t['btn.delete']}" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a>
</td>
<td>{$item.id}</td>

<td class="text-nowrap">
{$item.name|strip_tags|truncate:200:".."}
</td>

<td class="text-nowrap">
<a href="{$item.external_link}">{$item.external_link|strip_tags|truncate:200:".."}</a>
</td>

<td class="text-nowrap"><small>{$item.updated}</small></td>

</tr>
{/foreach}
</div>
</table>
{else}

<div class="col-sm-6 col-md-offset-2">
<div class="alert alert-info">{$t["not_found"]}</div>
</div>

{/if} 

<div class="col-sm-6">
<a href="{$lang_url}/admin/?section={$admin_section}&add_new" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span>{$t["btn.add_new"]}</a>
</div>