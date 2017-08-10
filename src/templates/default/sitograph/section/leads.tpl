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
        <td>UserID</td>
        <td>IP</td>
        <td>Device</td>
        <td>Browser</td>
        <td>OS</td>
        <td>Actions</td>
    </tr>

    {foreach from=$lead_list item=lead name=loop}

        <tr>
            <td>{$lead.id}</td>
            <td>
                {if $lead.status == "online"}
                    <span class="label label-success">online</span>
                {else}
                    <span class="label label-default">offline</span>
                {/if}

            </td>
            <td>{$lead.last_action}</td>
            <td>{$lead.user_id}</td>
            <td>{$lead.ip}</td>
            <td>
                {if $lead.ua_info && $lead.ua_info.device_type}
                    {$lead.ua_info.device_type}

                    {if $lead.ua_info && $lead.ua_info.device_brand}
                        <br>
                        {$lead.ua_info.device_brand}
                    {/if}
                    {if $lead.ua_info && $lead.ua_info.device_model}
                        {$lead.ua_info.device_model}
                    {/if}

                {/if}
            </td>
            <td>
                {if $lead.ua_info && $lead.ua_info.browser}
                    {$lead.ua_info.browser}

    {if $lead.ua_info.browser_version != "Unknown"}
                    {$lead.ua_info.browser_version}
    {/if}
                {/if}
            </td>
            <td>
                {if $lead.ua_info && $lead.ua_info.os}
                    {$lead.ua_info.os}
                    {$lead.ua_info.os_version}
                {/if}
            </td>
            <td><a href="/admin/?section=leads&range={$admin_range}&allinfo={$lead.id}">more info</a></td>
        </tr>

    {/foreach}

</table>
