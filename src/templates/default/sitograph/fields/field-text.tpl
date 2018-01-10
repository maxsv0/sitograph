{if strlen($value) > 1000}
    {assign var="rowsCount" value=20}
{elseif strlen($value) > 100}
    {assign var="rowsCount" value=10}
{else}
    {assign var="rowsCount" value=5}
{/if}
<div class="col-sm-12">
<textarea name="{$form_id}_{$item_id}" class="form-control" id="i{$item_id}" rows="{$rowsCount}" {if $readonly}readonly{/if}>{$value}</textarea>
</div>