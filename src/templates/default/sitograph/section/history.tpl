<table class="table">
<tr>
	<th>Page</th>
	<th>Time start</th>
	<th>Run time</th>
	<th>Modules loaded</th>
	<th>SQL queries</th>
</tr>
{foreach from=$debug_log_actions name=loop key=start item=action}
<tr>
	<td>{$action.page}</td>
	<td>{$action.start}</td>
	<td>{$action.run_time}</td>
	<td>
		<a class="link-dashed" data-toggle="collapse" data-target="#{$start|strtotime}_modules">{$action.modules|count} modules</a>
		
	</td>
	<td>
		<a class="link-dashed" data-toggle="collapse" data-target="#{$start|strtotime}_sql">{$action.sql|count} queries</a>
	</td>
</tr>
<tr id="{$start|strtotime}_modules" class="collapse">
	<td colspan="6">
		<p>Modules: {', '|implode:$action.modules}</p>
	</td>
</tr>
<tr id="{$start|strtotime}_sql" class="collapse">
	<td colspan="6">
		<p>SQL:</p>
		<p>{'<br>'|implode:$action.sql}</p>
	</td>
</tr>
{/foreach}
</table>

{if !$debug_log_actions}
	<div class="alert alert-danger">DEBUG_LOG has to be set to a correct path to enable Website History<br>
		Please go to website <a href="/admin/?section=config#DEBUG_LOG">config.php to edit</a></div>
{/if}