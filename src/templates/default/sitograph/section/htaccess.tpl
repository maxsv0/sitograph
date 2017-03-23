{if !$htaccess_edit_mode}

<div class="btnCover">
<div>
<a href="{$lang_url}/admin/?section=htaccess&edit_mode"><span class="glyphicon glyphicon-edit"></span> {$t["btn.edit"]}</a>
</div>
</div>

{if $htaccess}
<pre class="panel panel-success text-success" style="font-size: 14px;max-height: 500px;">
{$htaccess}
</pre>
{else}
<pre class="panel panel-danger text-danger" style="font-size: 14px;">
htaccess.txt {$t["not_found"]}
</pre>
{/if}
{/if}
{if $htaccess_edit_mode}

<form method="POST" action="{$lang_url}/admin/?section={$admin_section}">

<div class="form-group">
	<label for="exampleInputPassword1">htaccess.txt</label>
  <textarea class="form-control" rows="15" name="form_htaccess_content">{$htaccess}</textarea>
</div>


<div class="form-group">
<div class="text-right">
	<button type="submit" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove-circle">&nbsp;</span>{$t["btn.cancel"]}</button>
	<button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-ban-circle">&nbsp;</span>{$t["btn.reset"]}</button>
	<button type="submit" name="save" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-repeat">&nbsp;</span>{$t["btn.save"]}</button>
	<button type="submit" name="save_exit" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span>{$t["btn.save_exit"]}</button>
</div>
</div>

<input type="hidden" value="htaccess" name="section">

</form>
<br>
<br>

{/if}


