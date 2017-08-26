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
            <td class="col-sm-1">
                <p>
                    <a href="/api/lead/loadip/{$lead.id}/" class="btn btn-default btn-sm" onclick="load_ajax(this, $('#ipinfo{$lead.id}'));return false;"><span class="glyphicon glyphicon-refresh"></span> Load Info</a>
                </p>
                <p>
                    {$lead.ip}
                </p>
            </td>
            <td class="col-sm-2">
                <div class="infowell" id="ipinfo{$lead.id}">
{if $lead.ip_info}
        {include "$themePath/sitograph/seo/lead_ipinfo.tpl" info=$lead.ip_info}
{else}
    <i>empty</i>
{/if}
                </div>

            </td>
            <td class="col-sm-1">
                <p>
                    <a href="/api/lead/loadua/{$lead.id}/" class="btn btn-default btn-sm"  onclick="load_ajax(this, $('#uainfo{$lead.id}'));return false;"><span class="glyphicon glyphicon-refresh"></span> Load Info</a>
                </p>
                <p class="small" style="max-width:100px; overflow: auto; white-space: nowrap;">
                    {$lead.ua}
                </p>
            </td>
            <td class="col-sm-3">
                <div class="infowell" id="uainfo{$lead.id}">
{if $lead.ua_info}
        {include "$themePath/sitograph/seo/lead_uainfo.tpl" info=$lead.ua_info}
{else}
        <i>empty</i>
{/if}
                </div>
            </td>

        </tr>

    {/foreach}

</table>
