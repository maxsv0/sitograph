
{if $user.access == "superadmin"}

<form action="/admin/" class="well">
    <fieldset>
        <legend>Sitograph Terminal</legend>
        <p>Exec PHP code:</p>
        <p>
            <textarea class="form-control" name="terminal_code">{$terminal_code}</textarea>
        </p>
        <p>
            <input class="btn btn-default" type="submit" value="Submit Request" onclick="if(!confirm('Are you sure you want to execute this code? This action cannot be undone.')) return false;">
        </p>
    </fieldset>
</form>

{/if}


{if !$google_analytics_tracking_id}
	<div class="alert alert-danger">
	<b>{_t("msg.ga_not_configured")}</b><br>
	<a href="/admin/?section=site_settings&edit_key=google_analytics_tracking_id">{_t("admin.site_settings")} (google_analytics_tracking_id)</a>.
	</div>
{/if}

{include "$themePath/sitograph/section/realtime.tpl"}


<form action="/admin/" class="well">
    <fieldset>
        <legend>Sitograph Support</legend>
        <p>Send message directly to :</p>
        <p>
            <textarea class="form-control" name="terminal_code">{$terminal_code}</textarea>
        </p>
        <p>
            <input class="btn btn-default" type="submit" value="Submit Request" onclick="if(!confirm('Are you sure you want to execute this code? This action cannot be undone.')) return false;">
        </p>
    </fieldset>
</form>
