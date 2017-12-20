{if $admin_edit}


    {include "$themePath/sitograph/site_settings/edit.tpl"}


{else}

    <ul class="nav nav-pills" style="position: absolute;">
        <li{if $list_filter_group == "website"} class="active" {/if}><a href="/admin/?section=site_settings">Website</a></li>
        <li{if $list_filter_group == "theme"} class="active" {/if}><a href="/admin/?section=site_settings&filter_group=theme">Theme</a></li>
        <li{if $list_filter_group == "user"} class="active" {/if}><a href="/admin/?section=site_settings&filter_group=user">User</a></li>
{if $user.access === "superadmin"}
        <li{if $list_filter_group == "system"} class="active" {/if}><a href="/admin/?section=site_settings&filter_group=system"><span class="admin_crown">System</span></a></li>
{/if}
    </ul>

	{include "$themePath/sitograph/site_settings/list.tpl"}


{/if}



