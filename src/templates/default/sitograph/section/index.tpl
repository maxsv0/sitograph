{if !$google_analytics_tracking_id}
    <div class="alert alert-warning">
        <div class="row">
            <div class="col-xs-1"><img src="{CONTENT_URL}/{$google_analytics.preview}" class="img-thumbnail"></div>
            <div class="col-xs-11" style="padding-left:0;">
                <p><b>{_t("msg.ga_not_configured")}</b></p>
                <p><a href="{$lang_url}{$admin_url}?section=site_settings&edit_key=google_analytics_tracking_id">{_t("admin.site_settings")} (google_analytics_tracking_id)</a>.</p>
            </div>
        </div>
    </div>
{/if}

{include "$themePath/sitograph/section/realtime.tpl"}

{if $user.access == "dev"}
<br>

<form action="{$lang_url}{$admin_url}" class="well">
    <fieldset>
        <legend>Sitograph Terminal</legend>
        <p>Exec code:</p>
        <div class="row">
            <div class="col-xs-9">
                <textarea class="form-control" name="terminal_code" id="terminal_code">{$terminal_code}</textarea>
            </div>
            <div class="col-xs-3 text-center">
                <input class="btn btn-default btn-block" type="submit" value="Submit Request" onclick="if(!confirm('Are you sure you want to execute this code? This action cannot be undone.')) return false;">
            </div>

            {if $terminal_result}
                <div class="col-xs-12">
                    <h4>Result output:</h4>
                    <pre>{$terminal_result}</pre>
                </div>
            {/if}
        </div>
    </fieldset>
</form>
{/if}