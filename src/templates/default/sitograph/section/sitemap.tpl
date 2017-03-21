<p class="lead"><a href="{$home_url}sitemap.xml" target="_blank" style="font-size: 16px;">{$home_url}sitemap.xml <span class="glyphicon glyphicon-new-window"></span></a></p>



{if $admin_sitemap_edit_mode}

<form method="POST" action="/admin/?section={$admin_section}">

<div class="form-group">
  <textarea class="form-control" rows="15" name="form_sitemap_content">{$admin_sitemap}</textarea>
</div>


<div class="form-group">
<div class="text-right">
	<button type="submit" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove-circle">&nbsp;</span>{$t["btn.cancel"]}</button>
	<button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-ban-circle">&nbsp;</span>{$t["btn.reset"]}</button>
	<button type="submit" name="save" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-repeat">&nbsp;</span>{$t["btn.save"]}</button>
	<button type="submit" name="save_exit" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span>{$t["btn.save_exit"]}</button>
</div>
</div>

<input type="hidden" value="sitemap" name="section">

</form>
<br>
<br>

{else}


<div class="btnCover">
<div>
<a href="/admin/?section=sitemap&generate"><span class="glyphicon glyphicon-flash"></span> {_t("btn.generate")}</a>
&nbsp;&nbsp;&nbsp;
<a href="/admin/?section=sitemap&edit_mode"><span class="glyphicon glyphicon-edit"></span> {_t("btn.edit")}</a>
</div>
</div>
{if $admin_sitemap}
<pre class="panel panel-success text-success" style="font-size: 14px;max-height: 500px;">
{$admin_sitemap|htmlspecialchars}
</pre>
{else}
<pre class="panel panel-danger text-danger" style="font-size: 14px;">
sitemap.xml {$t["not_found"]}
</pre>
{/if}


{/if}