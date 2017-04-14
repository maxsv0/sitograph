{foreach from=$listTable[$show_parent_id] name=loop key=item_id item=item}

{if $show_parent_id == 0}
{assign var=level value=1}    
{/if}
<tr {if $item.debug}class="danger"{/if} data-index="{$item.parent_id}" data-level="{$level}" {if $structure_show && $structure_show[$item.parent_id] == $level && !empty($listTable[$item.id])}data-show="{$item.id}" class="selected"{/if}>

<td>
{if !empty($listTable[$item.id])}
<a href="javascript:void(0)" style="margin-top:3px" onclick="toogle_parent(this,'{$item.id}','{$level}')"><img id="block_{$item.id}" src="/content/images/sitograph/arrow_right.png"/></a>
{/if}
</td>




<td class="text-nowrap">
{section name=index start=1 loop=$level step=1}
<span>»</span>&nbsp;
{/section}
<span>{$item.name|strip_tags|truncate:200:".."}</span>
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
<span class="label label-danger">{_t("not_set")}</span>
{/if}

/

{if $item.page_template}
{$item.page_template}
{else}
<span class="label label-danger">{_t("not_set")}</span>
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

<td><small>{$item.updated|substr:0:10}</small></td>

<td class="text-nowrap">
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&edit={$item.id}" title="{$t['btn.edit']}" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&add_child={$item.id}" title="{$t['btn.add_child']}" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&duplicate={$item.id}" title="{$t['btn.duplicate']}" class="btn btn-warning"><span class="glyphicon glyphicon-duplicate"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&delete={$item.id}" onclick="if (!confirm('{$t["btn.remove_confirm"]}')) return false;" title="{$t['btn.delete']}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
</td>
</tr>


{if !empty($listTable[$item.id])}
        {assign var=level value=$level+1}    
        {include file="$themePath/sitograph/structure/list-level.tpl" listTable=$listTable show_parent_id=$item.id level=$level}
{/if}




{/foreach}