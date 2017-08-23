<ul class="nav nav-pills">
    <li class="active"><a href="/admin/?section=leads">Last 24h</a></li>
    <li><a href="/admin/?section=leads&range=7d">Last 7 days</a></li>
    <li><a href="/admin/?section=leads&range=30d">Last 30 days</a></li>
</ul>
<br>

<table class="table">
    <tr>
        <td>ID</td>
        <td>Status</td>
        <td>Date</td>
        <td>User</td>
        <td>Device</td>
        <td>IP</td>
        <td>IP info</td>
        <td>UA</td>
        <td>UA info</td>
    </tr>

    {foreach from=$lead_list item=lead name=loop}

        <tr>
            <td class="col-sm-1">{$lead.id}</td>
            <td class="col-sm-1">
                {if $lead.status == "online"}
                    <span class="label label-success">online</span>
                {else}
                    <span class="label label-default">offline</span>
                {/if}
            </td>
            <td class="col-sm-2">{$lead.last_action}</td>
            <td class="col-sm-1">
{if $lead.user_id}
    <p>ID: {$lead.user_id}</p>
    <p><a href="/admin/?section=users&table=users&edit={$lead.user_id}">edit user</a></p>
{else}
           <i>anonymous</i>
{/if}
            </td>
            <td class="col-sm-1">{$lead.device_type}</td>
            <td class="col-sm-2">
{if $lead.ip_info && false}

    {include "$themePath/sitograph/seo/lead_ipinfo.tpl" info=$lead.ip_info}

{else}
    <a href="/api/lead/loadip/{$lead.id}/" onclick="load_ajax(this);return false;">Load IP Info</a>
{/if}

            </td>
            <td class="col-sm-1">{$lead.ip}</td>
            <td class="col-sm-3">
                {if $lead.ua_info}

                    {include "$themePath/sitograph/seo/lead_uainfo.tpl" info=$lead.ua_info}

                {else}
                    <a href="/api/lead/loadua/{$lead.id}/" onclick="load_ajax(this);return false;">Load UA Info</a>
                {/if}
            </td>
            <td class="small" style="max-width:100px; overflow: auto; white-space: nowrap;">
                {$lead.ua}
            </td>
        </tr>

    {/foreach}

</table>
