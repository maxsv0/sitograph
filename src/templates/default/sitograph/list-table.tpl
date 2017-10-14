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
<td class="col-sm-2">
{if $itemField}
	<img src="{$itemField}" class="img-responsive" style="max-height:100px;">
{/if}
</td>
{elseif $type === "updated" || $type === "date"}
<td><small>{$itemField}</small></td>
{elseif $type === "bool"}
<td class="col-sm-1">
{if $admin_table_info.fields.$itemFieldID.readonly}
    {if $itemField}
        <span class="text-success">{$t["yes"]}</span>
    {else}
        <span class="text-danger">{$t["no"]}</span>
    {/if}
{else}
    {if $itemField}
        <span class="text-success bool-switch" data-id="{$item.id}" data-section="{$admin_section}" data-table="{$admin_table}" data-field="{$itemFieldID}" data-value="{$itemField}">{$t["yes"]}</span>
    {else}
        <span class="text-danger bool-switch" data-id="{$item.id}" data-section="{$admin_section}" data-table="{$admin_table}" data-field="{$itemFieldID}" data-value="{$itemField}">{$t["no"]}</span>
    {/if}
{/if}
</td>
{elseif $type === "doc"}
<td>{$itemField|htmlspecialchars|truncate:300:".."}</td>
{elseif $type === "url"}
<td class="col-sm-2">
{if $module_base_url}
	<a href="{$module_base_url}{$itemField}/" target="_blank">{$module_base_url}{$itemField}/<span class="glyphicon glyphicon-new-window"></span></a>
{elseif $itemField != "#"}
	<a href="{$itemField}" target="_blank">{$itemField}<span class="glyphicon glyphicon-new-window"></span></a>
{else}
    {$itemField}
{/if}
</td>
{elseif $type === "array"}
<td><pre class="small">{$itemField|@print_r}</pre></td>
{else}
<td>{$itemField|htmlspecialchars|truncate:200:".."}</td>
{/if}
{/if}
{/foreach}

<td class="col-sm-1">
    <ul class="list-btn">
        <li>
            <a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&edit={$item.id}&p={$admin_list_page}" title="{$t['btn.edit']}" class="btn btn-primary btn-sm">{$t['btn.edit']} <span class="glyphicon glyphicon-edit"></span></a>
        </li>
        <li>
            <a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&duplicate={$item.id}&p={$admin_list_page}" title="{$t['btn.duplicate']}" class="btn btn-warning btn-sm">{$t['btn.duplicate']} <span class="glyphicon glyphicon-duplicate"></span></a>
        </li>
        <li>
            <a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&delete={$item.id}&p={$admin_list_page}" title="{$t['btn.delete']}" class="btn btn-danger btn-sm" onclick="if (!confirm('{$t["btn.remove_confirm"]}')) return false;">{$t['btn.delete']} <span class="glyphicon glyphicon-remove"></span></a>
        </li>
    </ul>
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
    <ul class="list-btn">
        <li>
            <a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&export&export_full" class="btn btn-info"><span class="glyphicon glyphicon-download">&nbsp;</span>{_t("btn.export_all")}</a>
        </li>
        <li>
            <a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&export" class="btn btn-info"><span class="glyphicon glyphicon-download">&nbsp;</span>{_t("btn.export_table")}</a>
        </li>
    </ul>
</div>