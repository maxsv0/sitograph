{foreach from=$listTable[$show_parent_id] name=loop key=item_id item=item}

{if $show_parent_id == 0}
{assign var=level value=1}    
{/if}

{if $structure_show && $structure_show[$item.parent_id] == $level && !empty($listTable[$item.id])}

	<tr class="selected{if !$item.published} text-muted{/if}"  data-index="{$item.parent_id}" data-level="{$level}" data-show="{$item.id}">
{else}
	<tr class="{if !$item.published}text-muted{/if}" data-index="{$item.parent_id}" data-level="{$level}" >
{/if}

<td>
{if !empty($listTable[$item.id])}
<a href="javascript:void(0)" style="margin-top:3px" onclick="toogle_parent(this,'{$item.id}','{$level}')"><img id="block_{$item.id}" src="/content/images/sitograph/arrow_right.png"/></a>
{/if}
</td>




<td class="col-sm-2">
{section name=index start=1 loop=$level step=1}
<span>»</span>&nbsp;
{/section}
<span>{$item.name|strip_tags|truncate:200:".."}{if $item.debug} <span class="badge">debug</span>{/if}</span>
</td>

<td class="col-sm-2">
<a href="{$item.url}" target="_blank">{$item.url}<span class="glyphicon glyphicon-new-window"></span></a>
</td>

<td class="col-sm-2">
{if $item.page_template}
{$item.page_template}
{else}
<span class="label label-danger">{_t("not_set")}</span>
{/if}
<br>
{if $item.template}
	<small class="text-muted">{$item.template}</small>
{else}
	<span class="label label-danger">{_t("not_set")}</span>
{/if}
</td>

<td class="col-sm-1 text-center">
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
<td class="text-center col-sm-1">
{if $item.sitemap}
	<span class="text-success bool-switch" data-id="{$item.id}" data-section="{$admin_section}" data-table="{$admin_table}" data-field="sitemap" data-value="1">{$t["yes"]}</span>
{else}
	<span class="text-danger bool-switch" data-id="{$item.id}" data-section="{$admin_section}" data-table="{$admin_table}" data-field="sitemap" data-value="0">{$t["no"]}</span>
{/if}
</td>
<td class="text-center col-sm-1">
<small>{$item.updated}</small>
</td>

<td class="col-sm-3">
<ul class="list-btn">
	<li>
		<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&edit={$item.id}" title="{$t['btn.edit']}" class="btn btn-default btn-sm">{$t['btn.edit']} <span class="glyphicon glyphicon-edit"></span></a>
	</li>
	<li>
		<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&add_child={$item.id}" title="{$t['btn.add_child']}" class="btn btn-default btn-sm">{$t['btn.add_child']} <span class="glyphicon glyphicon-plus"></span></a>
	</li>
	<li>
		<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&duplicate={$item.id}" title="{$t['btn.duplicate']}" class="btn btn-default btn-sm">{$t['btn.duplicate']} <span class="glyphicon glyphicon-duplicate"></span></a>
	</li>
	<li>
		<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&delete={$item.id}" onclick="if (!confirm('{$t["btn.remove_confirm"]}')) return false;" title="{$t['btn.delete']}" class="btn btn-danger btn-sm">{$t['btn.delete']} <span class="glyphicon glyphicon-remove"></span></a>
	</li>
</ul>
</td>
</tr>


{if !empty($listTable[$item.id])}
        {assign var=level value=$level+1}    
        {include file="$themePath/sitograph/structure/list-level.tpl" listTable=$listTable show_parent_id=$item.id level=$level}
{/if}




{/foreach}