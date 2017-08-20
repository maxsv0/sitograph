{if $listTable}
<div class="table-responsive">
<table class="table table-hover table-striped table-module">

{foreach from=$listTable name=loop key=item_id item=item}

{if $smarty.foreach.loop.first}
<tr>
{foreach from=$item key=itemFieldID item=itemField} 
{if !in_array($itemFieldID, $admin_list_skip) && !empty($admin_table_info.fields.$itemFieldID.type)}
<th{if $table_sort == $itemFieldID} class='colactive'{/if}>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort={$itemFieldID}&sortd={$table_sortd_rev}&p={$admin_list_page}">{_t("table.$admin_table.$itemFieldID")}</a>{if $table_sort == $itemFieldID}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
{/if}
{/foreach}
<th>{$t["actions"]}</th>
</tr>
{/if}

{if $item.published}
<tr>
{else}
<tr class="danger">
{/if}
{foreach from=$item key=itemFieldID item=itemField}
{if !in_array($itemFieldID, $admin_list_skip) && !empty($admin_table_info.fields.$itemFieldID.type)}
{assign var="type" value=$admin_table_info.fields.$itemFieldID.type}
{if $type === "pic"}
<td>
{if $itemField}
	<img src="{$itemField}" class="img-responsive" style="max-height:100px;">
{/if}
</td>
{elseif $type === "updated" || $type === "date"}
<td><small>{$itemField}</small></td>
{elseif $type === "bool"}
<td>
{if $itemField}
<span class="text-success">{$t["yes"]}</span>
{else}
<span class="text-danger">{$t["no"]}</span>
{/if}
</td>
{elseif $type === "doc"}
<td>{$itemField|htmlspecialchars|truncate:300:".."}</td>
{elseif $type === "array"}
<td><pre class="small">{$itemField|@print_r}</pre></td>
{else}
<td>{$itemField|htmlspecialchars|truncate:60:".."}</td>
{/if}
{/if}
{/foreach}

<td class="text-nowrap">
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&edit={$item.id}&p={$admin_list_page}" title="{$t['btn.edit']}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&duplicate={$item.id}&p={$admin_list_page}" title="{$t['btn.duplicate']}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-duplicate"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&delete={$item.id}&p={$admin_list_page}" title="{$t['btn.delete']}" class="btn btn-danger btn-sm" onclick="if (!confirm('{$t["btn.remove_confirm"]}')) return false;"><span class="glyphicon glyphicon-remove"></span></a>
</td>


</tr>
{/foreach}
</div>
</table>


{if $admin_list_pages}
{include file="$themePath/widget/pagination.tpl" pagination=$admin_list_pages urlsuffix="&section=$admin_section&table=$admin_table&sort=$table_sort&sortd=$table_sortd"}
{/if}



{else}

<div class="col-sm-6 col-md-offset-2">
<div class="alert alert-info">{_t("not_found")}</div>
</div>

{/if} 

<div class="col-sm-6">
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&add_new" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span>{$t["btn.add_new"]}</a>
</div>

<div class="col-sm-6 text-right">
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&export" class="btn btn-info"><span class="glyphicon glyphicon-download">&nbsp;</span>{_t("btn.export_table")}</a>
</div>