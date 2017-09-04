<div class="col-sm-12">

<select multiple class="form-control" id="i{$item_id}" name="{$form_id}_{$item_id}[]" {if $readonly}disabled{/if}>
<option value="" {if empty($value)}selected{/if}></option>
{foreach from=$itemField.data key=dataID item=$dataValue}
<option value="{$dataID}" {if $value && in_array($dataID, $value)}selected{/if}>{$itemField.data.$dataID}</option>
{/foreach}
</select>

 </div>