<p><a href="{$home_url}robots.txt" target="_blank" style="font-size: 14px;">Robots.txt <span class="glyphicon glyphicon-new-window"></span></a></p>

<div class="btnCover">
<div>
<a href="{$lang_url}{$admin_url}?section=robots&edit_mode" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> {$t["btn.edit"]}</a>
</div>
</div>
{if $robots}
<pre class="panel panel-success text-success" style="font-size: 14px;max-height: 500px;">
{$robots}
</pre>
{else}
<pre class="panel panel-danger text-danger" style="font-size: 14px;">
Robots.txt {$t["not_found"]}
</pre>
{/if}

{if $robots_edit_mode}

<form method="POST" action="{$lang_url}{$admin_url}?section={$admin_section}">

<div class="form-group">
	<label for="exampleInputPassword1">robots.txt</label>
  <textarea class="form-control" rows="15" name="form_robots_content">{$robots}</textarea>
</div>


<div class="form-group">
<div class="text-right">
	<button type="submit" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove-circle">&nbsp;</span>{$t["btn.cancel"]}</button>
	<button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-ban-circle">&nbsp;</span>{$t["btn.reset"]}</button>
	<button type="submit" name="save" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-repeat">&nbsp;</span>{$t["btn.save"]}</button>
	<button type="submit" name="save_exit" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span>{$t["btn.save_exit"]}</button>
</div>
</div>

<input type="hidden" value="robots" name="section">

</form>
<br>
<br>

{/if}


<p>{$t["admin.robots_example_open"]}</p>
<pre class="panel panel-info text-muted">
User-agent: * 
Allow: / 
</pre>

<p>{$t["admin.robots_example_closed"]}</p>
<pre class="panel panel-info text-muted">
User-agent: * 
Disallow: / 
</pre>

<p>{$t["admin.robots_example_seo"]}</p>
<pre class="panel panel-info text-muted">
User-agent: * 
Disallow: {$admin_url}*
Sitemap: {$home_url}sitemap.xml 

User-agent: Yandex
Disallow: {$admin_url}*
Host: {$host}
Sitemap: {$home_url} sitemap.xml
</pre>

