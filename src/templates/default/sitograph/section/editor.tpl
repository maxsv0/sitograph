{if $file_list}
	<h4>Files found</h4>
    {foreach from=$file_list item=file_path}
		<p>
			<a href="{$lang_url}{$admin_url}?section=editor&edit_file={$file_path}">{$file_path}</a>
		</p>
    {/foreach}

{else}
	<h3>Editing file: {$file_path}</h3>

	<div class="btnCover">
		<div>
			<a href="{$lang_url}{$admin_url}?section=editor&edit_file={$file_path}" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> Read file</a>
			&nbsp;&nbsp;&nbsp;
			<a href="{$lang_url}{$admin_url}?section=editor&edit_file={$file_path}&edit_mode" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> Edit file</a>
		</div>
	</div>

    {if !$file_edit_mode}

        {if $file_path}
			<pre class="panel panel-success text-success" style="font-size: 14px;max-height: 500px;">
{$file_content|escape}
</pre>
        {else}
			<pre class="panel panel-danger text-danger" style="font-size: 14px;">
{$t["not_found"]}
</pre>
			<a class="btn btn-primary" href="{$lang_url}{$admin_url}?section=editor&edit_file={$file_path}&create_confirm">Create File</a>
        {/if}

    {else}
		<form method="POST" action="{$lang_url}{$admin_url}?section={$admin_section}">

			<div class="form-group">
				<textarea class="form-control" rows="15" name="form_file_content">{$file_content|escape}</textarea>
			</div>

			<div class="form-group">
				<div class="text-left col-sm-6">
					<button type="submit" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove-circle">&nbsp;</span>{$t["btn.cancel"]}</button>
					<button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-ban-circle">&nbsp;</span>{$t["btn.reset"]}</button>
				</div>
				<div class="text-right col-sm-6">
					<button type="submit" name="save" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-repeat">&nbsp;</span>{$t["btn.save"]}</button>
				</div>
			</div>

			<input type="hidden" value="editor" name="section">
			<input type="hidden" value="{$file_path}" name="edit_file">

		</form>
    {/if}

{/if}

