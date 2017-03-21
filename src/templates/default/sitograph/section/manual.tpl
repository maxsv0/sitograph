{if $admin_manual_edit_mode}

<form method="POST" action="/admin/?section={$admin_section}">

<div class="form-group">
  <textarea class="form-control editor" rows="15" name="form_manual_content">{$admin_manual}</textarea>
</div>


<div class="form-group">
<div class="text-right">
	<button type="submit" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove-circle">&nbsp;</span>{$t["btn.cancel"]}</button>
	<button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-ban-circle">&nbsp;</span>{$t["btn.reset"]}</button>
	<button type="submit" name="save" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-repeat">&nbsp;</span>{$t["btn.save"]}</button>
	<button type="submit" name="save_exit" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span>{$t["btn.save_exit"]}</button>
</div>
</div>

<input type="hidden" value="manual" name="section">

</form>
<br>
<br>

{else}



{if $user.access === "superadmin"}
<div class="btnCover">
<div>
<a href="/admin/?section=manual&edit_mode"><span class="glyphicon glyphicon-edit"></span> {$t["btn.edit"]}</a>
</div>
</div>
{/if}

{if $admin_manual}
<div class="well">
{$admin_manual}
</div>
{else}
<div class="well text-danger" style="font-size: 14px;">
manual.html {$t["not_found"]}
</div>
{/if}



{/if}
