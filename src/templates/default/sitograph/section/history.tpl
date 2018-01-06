<table class="table table-hover table-striped table-module">
<tr>
	<th class="col-sm-4">Page</th>
	<th class="col-sm-3">Time start</th>
	<th class="col-sm-3">Run time</th>
	<th class="col-sm-2">Actions</th>
</tr>
{foreach from=$debug_log_actions name=loop key=start item=action}
<tr>
	<td>{$action.page}</td>
	<td>{$action.start}</td>
	<td>{$action.run_time}</td>
	<td>
	<p>
		<a class="link-dashed" data-toggle="collapse" data-target="#{$start|strtotime}_modules">{$action.modules|count} modules</a>
	</p>
	<p>
		<a class="link-dashed" data-toggle="collapse" data-target="#{$start|strtotime}_sql">Show SQL queries: {$action.sql|count} </a>
	</p>
	<p>
		<a class="link-dashed" data-toggle="collapse" data-target="#{$start|strtotime}_raw">{$action.raw_size}</a>
	</p>
	</td>
</tr>
<tr id="{$start|strtotime}_modules" class="collapse">
	<td colspan="3">
		<div class="well">
		<p>Modules: {', '|implode:$action.modules}</p>
	</td>
	<td>{$start}</td>
</tr>
<tr id="{$start|strtotime}_sql" class="collapse">
	<td colspan="3">
		<div class="well">
		<p>{'<br>'|implode:$action.sql}</p>
		</div>
	</td>
	<td>{$start}</td>
</tr>
<tr id="{$start|strtotime}_raw" class="collapse">
	<td colspan="3">
		<div class="well">
		<p>{$action.raw|htmlspecialchars|nl2br}</p>
		</div>
	</td>
	<td>{$start}</td>
</tr>
{/foreach}
</table>

{if !$debug_log_actions}
<div class="alert alert-warning">
	<div class="row">
		<div class="col-xs-1"><img src="{CONTENT_URL}/{$msv_core.preview}" class="img-thumbnail"></div>
		<div class="col-xs-11" style="padding-left:0;">
			<p><b>Debug History</b> is not active. DEBUG_LOG must contain valid path and DEBUG set to 1.</p>
			<p>
				<a href="{$lang_url}/admin/?section=config#DEBUG_LOG">{_t("admin.config")} (DEBUG_LOG)</a>, <a href="{$lang_url}/admin/?section=config#DEBUG">{_t("admin.config")} (DEBUG)</a>.
			</p>
		</div>
	</div>
</div>
{else}

	<p>
		<a class="btn btn-danger" href="{$lang_url}/admin/?section=history&truncate_log">Truncate log file</a>

		&nbsp;&nbsp;&nbsp;&nbsp;
		Log file:
		<b>{DEBUG_LOG}</b>, {msv_format_size(filesize(DEBUG_LOG))}, {$debug_log_actions|count} entries
	</p>
{/if}