{assign var="listTable" value=$admin_list}

{if $listTable}
<div class="table-responsive">
<table class="table table-hover table-striped table-module">
<tr>
<th{if $table_sort == "id"} class='colactive'{/if}>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=id&sortd={$table_sortd_rev}">{$t["table.users.id"]}</a>
{if $table_sort == "id"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th{if $table_sort == "status"} class='colactive'{/if}>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=status&sortd={$table_sortd_rev}">{$t["users.status"]}</a>
{if $table_sort == "status"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th{if $table_sort == "access"} class='colactive'{/if}>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=access&sortd={$table_sortd_rev}">{$t["table.users.access"]}</a>
{if $table_sort == "access"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th{if $table_sort == "email"} class='colactive'{/if}>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=email&sortd={$table_sortd_rev}">{$t["table.users.email"]}</a>
{if $table_sort == "email"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th{if $table_sort == "name"} class='colactive'{/if}>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=name&sortd={$table_sortd_rev}">{$t["table.users.name"]}</a>
{if $table_sort == "name"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th{if $table_sort == "iss"} class='colactive'{/if}>
<a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&sort=iss&sortd={$table_sortd_rev}">{$t["table.users.iss"]}</a>
{if $table_sort == "iss"}{if $table_sortd == "asc"}&darr;{else}&uarr;{/if}{/if}
</th>
<th{if $table_sort == "updated"} class='colactive'{/if}>
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
    {if $item.status == "online"}
		<span class="label label-success">{_t("users.online")}</span>
    {else}
		<span class="label label-default">{_t("users.offline")}</span>
    {/if}
	<div class="small">
        <a href="/admin/?section=leads&lead_id={$item["lead"]["id"]}">open info</a>
	</div>
</td>

<td>{$item.access}</td>

<td class="text-nowrap">
{$item.email}
	<br>
{if $item.email_verified}
	<span class="label label-success">{_t("msg.users.email_verified")}</span>
{else}
	<span class="label label-danger">{_t("msg.users.email_notverified")}</span>
{/if}
	<a href="/admin/?section=send_email&send_to={$item.email}" class="btn btn-default btn-sm">send email..</a>
</td>

<td class="text-nowrap">
{$item.name|strip_tags|truncate:200:".."}
</td>


<td>{$item.iss}</td>
<td class="text-nowrap"><small>{$item.updated}</small></td>
<td class="col-sm-2">
{if $item.access_data !== "superadmin" || ($item.access_data === "superadmin" && $user.access === "superadmin")}
	<ul class="list-btn">
		<li><a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&reset={$item.id}" title="Reset Password" class="btn btn-primary btn-sm" onclick="prompt_password(this); return false;">Reset Password <span class="glyphicon glyphicon-lock"></span></a></li>
		<li><a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&edit={$item.id}" title="{_t("btn.edit")}" class="btn btn-primary btn-sm">{_t("btn.edit")} <span class="glyphicon glyphicon-edit"></span></a></li>
		<li><a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&duplicate={$item.id}" title="{_t("btn.duplicate")}" class="btn btn-warning btn-sm">{_t("btn.duplicate")} <span class="glyphicon glyphicon-duplicate"></span></a></li>
		<li><a href="{$lang_url}/admin/?section={$admin_section}&table={$admin_table}&delete={$item.id}" title="Delete" class="btn btn-danger btn-sm">Delete <span class="glyphicon glyphicon-remove"></span></a></li>
	</ul>
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