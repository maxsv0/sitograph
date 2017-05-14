
<div class="admin-main-msv hide">
    <ul class="admin-main-msv-list">
        <li>
        <span class="glyphicon glyphicon-pencil"></span>
        <span class="admin-main-msv-title">Blog</span>
        </li>
         <li>
        <span class="glyphicon glyphicon-picture"></span>
        <span class="admin-main-msv-title">Gallery</span>
        </li>

    </ul>
</div>


{if !$google_analytics_tracking_id}
	<div class="alert alert-danger">
	<b>{_t("msg.ga_not_configured")}</b><br>
	<a href="/admin/?section=site_settings&edit_key=google_analytics_tracking_id">{_t("admin.site_settings")} (google_analytics_tracking_id)</a>.
	</div>
{/if}

{if $GA_access_token}

	{include "$themePath/sitograph/section/realtime.tpl"}

{else}

	<div class="alert alert-danger">
	<b>{_t("msg.ga_api_not_configured")}</b><br>
	{_t("msg.ga_json_not_configured")} <br>
	<a href="/admin/?section=site_settings&edit_key=google_service_auth_json">{_t("admin.site_settings")} (google_service_auth_json)</a>.
	</div>
{/if}