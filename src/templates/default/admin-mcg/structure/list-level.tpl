{foreach from=$listTable name=loop key=item_id item=item}
{if $item.parent_id == $show_parent_id}
{if $item.debug}
<tr class="danger">
{else}
<tr>
{/if}

<td>|</td>

<td class="text-nowrap">
{$item.name|strip_tags|truncate:200:".."}
{if $item.debug}
<div><span class="badge">debug</span></div>
{/if}
</td>

<td class="text-nowrap">
<a href="{$item.url}" target="_blank" style="text-decoration:none;">{$item.url} <span class="glyphicon glyphicon-new-window"></span></a>
</td>

<td class="text-nowrap">
<small>
{if $item.template}
{if $item.template === "default"}
	<span class="text-muted">{$item.template}</span>
{else}
	<span class="text-info">{$item.template}</span>
{/if}
{else}
<span class="label label-danger">не указан</span>
{/if}

/

{if $item.page_template}
{$item.page_template}
{else}
<span class="label label-danger">не указан</span>
{/if}
</small>
</td>

<td class="text-nowrap text-center">
{if $item.access === "everyone"}
	<span class="text-success">{$item.access_data}</span>
{elseif $item.access === "user"}
	<span class="text-warning">{$item.access_data}</span>
{elseif $item.access === "admin"}
	<span class="text-danger">{$item.access_data}</span>
{elseif $item.access === "superadmin"}
	<span class="text-danger"><b>{$item.access_data}</b></span>
{else}
	{$item.access_data}
{/if}
</td>
<td class="text-nowrap text-center">
{if $item.sitemap}
<span class="text-success">{$t["yes"]}</span>
{else}
<span class="text-danger">{$t["no"]}</span>
{/if}
</td>
<td class="text-nowrap text-center">
{if $item.published}
<span class="text-success">{$t["yes"]}</span>
{else}
<span class="text-danger">{$t["no"]}</span>
{/if}
</td>

<td><small>{$item.updated}</small></td>

<td class="text-nowrap">
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&delete={$item.id}" onclick="if (!confirm('Вы уверены что хотите удалить?')) return false;" title="{$t['btn.delete']}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&duplicate={$item.id}" title="{$t['btn.duplicate']}" class="btn btn-warning"><span class="glyphicon glyphicon-duplicate"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&add_child={$item.id}" title="{$t['btn.add_child']}" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&edit={$item.id}" title="{$t['btn.edit']}" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
</td>
</tr>

{include file="$themePath/admin-mcg/structure/list-level2.tpl" show_parent_id=$item.id}

{/if}
{/foreach}