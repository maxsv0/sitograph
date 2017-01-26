{if $item_id}

<div class="form-group">
<small class="text-muted" style="position:absolute;opacity:0.2;">
{$t["type.$item_type"]}
</small>
<label for="i{$item_id}" class="col-sm-2 control-label">
{_t("table.$admin_table.$item_name")}
{if $item_type === "pic"}

	<p class="text-info" style="margin-top:10px;font-weight:300;">
	{_t("form.image_max_size")}: 
	</p>
	<p class="text-nowrap">
{if $itemField["max-width"]}
{$itemField["max-width"]} px
{else}
any
{/if}
	<small class="text-muted">х</small> 
{if $itemField["max-height"]}
{$itemField["max-height"]} px
{else}
any
{/if}
</p>
	
	
{/if}
</label>

{if $item_type === "doc"}

	{include "$themePath/admin/fields/field-doc.tpl"}
	
{elseif $item_type === "text"}

	{include "$themePath/admin/fields/field-text.tpl"}
	
{elseif $item_type === "updated"}

	{include "$themePath/admin/fields/field-updated.tpl"}
	
{elseif $item_type === "lang"}

	{include "$themePath/admin/fields/field-lang.tpl"}
	
{elseif $item_type === "bool" || $item_type === "published" || $item_type === "deleted"}

	{include "$themePath/admin/fields/field-bool.tpl"}
	
{elseif $item_type === "date"}

	{include "$themePath/admin/fields/field-date.tpl"}

{elseif $item_type === "select"}

	{include "$themePath/admin/fields/field-select.tpl"}
	
{elseif $item_type === "file"}

	{include "$themePath/admin/fields/field-file.tpl"}
	
{elseif $item_type === "pic"}

	{include "$themePath/admin/fields/field-picture.tpl"}
	
{elseif $item_type === "multiselect"}

	{include "$themePath/admin/fields/field-multiselect.tpl"}
	
{else}

	{include "$themePath/admin/fields/field-default.tpl"}
	
{/if}

</div>


{else}
empty item_id $item_name:{$item_name}
{/if}