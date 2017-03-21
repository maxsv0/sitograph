
<div class="col-sm-4">
	<select name="{$form_id}_{$item_id}" class="form-control">
<option value="*" {if $value == "*"}selected{/if}>*</option>
{foreach from=$languages item=langID}
<option value="{$langID}" {if $value == $langID}selected{/if}>{$langID}</option>
{/foreach}
	</select>
</div>