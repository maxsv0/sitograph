<p class="text-right">
    <button class="btn btn-default" data-toggle="collapse" data-target="#row_add"><span class='glyphicon glyphicon-ok'></span> {$t["btn.add_new"]} <span class='caret'></span></button>

    &nbsp;&nbsp;

    <button class="btn btn-default" data-toggle="collapse" data-target="#row_filter"><span class='glyphicon glyphicon-cog'></span> Options <span class='caret'></span></button>
</p>

<div class="collapse" id="row_add">
    <div class="row">
    <div class="col-sm-12">
        <div class="well">
        {include "$themePath/sitograph/form-table.tpl" dataList=$admin_edit}
        </div>
    </div>
    </div>
</div>

<div class="collapse" id="row_filter">
    <div class="row">
    <div class="col-sm-10 col-sm-offset-2 text-right">
        <ul>
            <form action="/admin/" method="GET">
                <div class="well text-left">
                    {foreach from=$admin_filter_fields key=itemFieldID item=itemField}
                        <div class="row form-group">
                            <label for="itableLimit" class="col-sm-4 control-label">{_t("table.$admin_table.$itemFieldID")}</label>
                            <div class="col-sm-8">
{if $itemField.type == "select"}
                            <select class="form-control" id="i{$itemFieldID}" name="filter_{$itemFieldID}">
                                <option value=""></option>
                                {foreach from=$itemField.data key=dataID item=dataValue}
                                    <option value="{$dataID}" {if ($dataID == $itemField.value)}selected{/if}>{$dataValue}</option>
                                {/foreach}
                            </select>
{else}
                            <input type="text" class="form-control" id="i{$itemFieldID}" placeholder="{$itemFieldID}" name="filter_{$itemFieldID}" value="{$itemField.value|htmlspecialchars}">
{/if}
                            </div>
                        </div>
                    {/foreach}


                    <div class="row form-group">
                        <label for="itableLimit" class="col-sm-4 control-label">Items per page</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="itableLimit" placeholder="Number items per page" name="list_limit" value="{$table_limit}">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputName" class="col-sm-4 control-label">Show/hide columns</label>
                        <div class="col-sm-8 checkbox small">
                            {foreach from=$admin_list_fields item=itemFieldID}
                                <label class="col-sm-6">
                                    <input type="checkbox" {if !in_array($itemFieldID, $admin_list_skip)}checked{/if} name="utf[]" value="{$itemFieldID}"> {_t("table.$admin_table.$itemFieldID")}
                                </label>
                            {/foreach}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="inputName" class="col-sm-4 control-label">Sort by</label>
                        <div class="col-sm-4">
                            <select class="form-control col-sm-4" name="sort">
                                {foreach from=$admin_list_fields item=itemFieldID}
                                    <option value="{$itemFieldID}" {if ($itemFieldID == $table_sort)}selected{/if}>{$itemFieldID}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control col-sm-4" name="sortd">
                                <option value="desc">desc</option>
                                <option value="asc" {if ("asc" == $table_sortd)}selected{/if}>asc</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-7">
                            {if $user.access === "superadmin" && $admin_menu_item.module}
                                <a href="{$lang_url}/admin/?section=module_settings&module={$admin_menu_item.module}#tables" class="btn btn-info"><span class="glyphicon glyphicon-cog">&nbsp;</span><span class="admin_crown">Config Table</span></a></p>
                            {/if}
                        </div>
                        <div class="col-sm-5 text-right">
                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span>Save settings</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="section" value="{$admin_section}">
                <input type="hidden" name="table" value="{$admin_table}">
            </form>
        </ul>
    </div>
    </div>
</div>

{if $listTable}
<div class="table-responsive">
<table class="table table-hover table-striped table-module">

{foreach from=$listTable name=loop key=item_id item=item}

{if $smarty.foreach.loop.first}
<tr>
{foreach from=$item key=itemFieldID item=itemField} 
{if !in_array($itemFieldID, $admin_list_skip) && !empty($admin_table_info.fields.$itemFieldID.type)}
<th{if $table_sort == $itemFieldID} class='colactive'{/if}>
    <a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort={$itemFieldID}&sortd={$table_sortd_rev}&p={$admin_list_page}&list_limit={$table_limit}">{_t("table.$admin_table.$itemFieldID")}</a>{if $table_sort == $itemFieldID}{if $table_sortd == "asc"}<span>&darr;</span>{else}<span>&uarr;</span>{/if}{/if}
</th>
{/if}
{/foreach}
<th>{$t["actions"]}</th>
</tr>
{/if}

{if $item.published}
<tr>
{else}
<tr class="text-muted">
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
{elseif $type === "bool" || $type ==="published"}
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
    <small>
{if $module_base_url}
    <a href="{$module_base_url}{$itemField}/" target="_blank">{$module_base_url}{$itemField}/<span class="glyphicon glyphicon-new-window"></span></a>
{elseif $itemField != "#"}
	<a href="{$itemField}" target="_blank">{$itemField}<span class="glyphicon glyphicon-new-window"></span></a>
{else}
    {$itemField}
{/if}
    </small>
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
            <a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&edit={$item.id}&p={$admin_list_page}" title="{$t['btn.edit']}" class="btn btn-default btn-sm">{$t['btn.edit']} <span class="glyphicon glyphicon-edit"></span></a>
        </li>
        <li>
            <a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&duplicate={$item.id}&p={$admin_list_page}" title="{$t['btn.duplicate']}" class="btn btn-default btn-sm">{$t['btn.duplicate']} <span class="glyphicon glyphicon-duplicate"></span></a>
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
    {include file="$themePath/widget/pagination.tpl" pagination=$admin_list_pages urlsuffix="&section=$admin_section&table=$admin_table&sort=$table_sort&sortd=$table_sortd&list_limit=$table_limit"}
{/if}


{else}

<div class="col-sm-6 col-md-offset-2">
<div class="alert alert-info">{_t("not_found")}</div>
</div>

{/if} 

<div class="col-sm-6">
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&add_new" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-ok">&nbsp;</span>{$t["btn.add_new"]} ..</a>
</div>

<div class="col-sm-6 text-right">
    <a href="{$lang_url}/admin/?section=export&table={$admin_table}&sort={$table_sort}&sortd={$table_sortd}&p={$admin_list_page}&pn={$table_limit}" class="btn btn-info"><span class="glyphicon glyphicon-download">&nbsp;</span>{_t("btn.export_table")}</a>
    &nbsp;&nbsp;
    <a href="{$lang_url}/admin/?section=export&table={$admin_table}&sort={$table_sort}&sortd={$table_sortd}&export_full" class="btn btn-info"><span class="glyphicon glyphicon-download">&nbsp;</span>{_t("btn.export_table_full")}</a>
</div>
