{assign var="listTable" value=$admin_list}

{if $listTable}
<div class="table-responsive">
<table class="table table-hover table-striped table-module">

<th>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=id&sortd={$table_sortd_rev}">{$t["table.users.id"]}</a>
{if $table_sort == "id"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=email&sortd={$table_sortd_rev}">{$t["table.users.email"]}</a>
{if $table_sort == "email"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=name&sortd={$table_sortd_rev}">{$t["table.users.name"]}</a>
{if $table_sort == "name"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=phone&sortd={$table_sortd_rev}">{$t["table.users.phone"]}</a>
{if $table_sort == "phone"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=access&sortd={$table_sortd_rev}">{$t["table.users.access"]}</a>
{if $table_sort == "access"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=iss&sortd={$table_sortd_rev}">{$t["table.users.iss"]}</a>
{if $table_sort == "iss"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=updated&sortd={$table_sortd_rev}">{$t["table.users.updated"]}</a>
{if $table_sort == "updated"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th>{$t["actions"]}</th>
</tr>

{foreach from=$listTable name=loop key=item_id item=item}
{if $item.published}
<tr>
{else}
<tr class="danger">
{/if}
<td>{$item.id}</td>

<td class="text-nowrap">
{$item.email}
</td>

<td class="text-nowrap">
{$item.name|strip_tags|truncate:200:".."}
</td>

<td class="text-nowrap">
{$item.phone|strip_tags|truncate:200:".."}
</td>

<td>{$item.access}</td>
<td>{$item.iss}</td>
<td class="text-nowrap"><small>{$item.updated}</small></td>
<td class="text-nowrap">
{if $item.access_data !== "superadmin" || ($item.access_data === "superadmin" && $user.access === "superadmin")}
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&edit={$item.id}" title="Edit" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&duplicate={$item.id}" title="Duplicate" class="btn btn-warning"><span class="glyphicon glyphicon-duplicate"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&delete={$item.id}" title="Delete" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
{/if}
</td>
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