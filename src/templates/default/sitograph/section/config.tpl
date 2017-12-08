<div class="alert alert-warning">
	<b>WARNING!</b> PLEASE NOTE: After clicking the <b>Save</b> button changes will be made directly to the <b>config.php</b> file. <br><b>THIS CAN CAUSE WEBSITE STOP FUNCTIONING.</b>
</div>

<p class="text-right">
	<a href="/admin/?section=config&remove_config" class="btn btn-danger" onclick="if(!confirm('Are you sure you want to delete config.php file? The website will stop working and Installation Wizard will be launched.')) return false;">Remove config.php</a>
</p>
<br>

<form action="{$lang_url}/admin/" method="POST">

<table class="table">

{foreach from=$admin_config_list key=dataName item=dataValue}
<tr id="{$dataName}">
	<td>{$dataName}</td>
	<td><input type="text" value="{$dataValue}" name="config_{$dataName}" class="form-control"></td>
</tr>
{/foreach}

</table>


<input type="hidden" value="{$admin_section}" name="section">

<div class="form-group">
<div class="text-right">
	<button type="submit" name="save" id="btnSave" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-repeat">&nbsp;</span>{$t["btn.save"]}</button>
</div>
</div>
</form>