<ul class="nav nav-pills">
    <li{if $list_filter_group == "website"} class="active" {/if}><a href="{$admin_url}?section=site_settings">Website</a></li>
    <li{if $list_filter_group == "theme"} class="active" {/if}><a href="{$admin_url}?section=site_settings&filter_group=theme">Theme</a></li>
{if $user.access === "dev"}
    <li{if $list_filter_group == "user"} class="active" {/if}><a href="{$admin_url}?section=site_settings&filter_group=user"><span class="admin_crown">User</span></a></li>
    <li{if $list_filter_group == "system"} class="active" {/if}><a href="{$admin_url}?section=site_settings&filter_group=system"><span class="admin_crown">System</span></a></li>
{/if}
</ul>
{if $admin_edit}


    {include "$themePath/sitograph/site_settings/edit.tpl"}


{else}


	{include "$themePath/sitograph/site_settings/list.tpl"}


{/if}



