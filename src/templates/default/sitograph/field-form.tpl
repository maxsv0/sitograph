{if $item_id}

<div class="form-group">
{if $item_type === "pic" || $item_type === "doc" || $item_type === "text"}
    <label for="i{$item_id}" class="col-sm-12 control-label" style="font-size: 15px; margin-bottom:5px;">
    {_t("table.$admin_table.$item_name")}
    {if $item_type === "pic"}
    
    	<p class="text-info" style="margin-top:10px;font-weight:300;">
    	{_t("form.image_max_size")}: 
    	
    <span class="text-nowrap">
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
    </span>
    	
    	</p>

    	
    	
    {/if}
    </label>
{/if}    

{if $item_type === "doc"}

	{include "$themePath/sitograph/fields/field-doc.tpl"}
	
{elseif $item_type === "text"}

	{include "$themePath/sitograph/fields/field-text.tpl"}
	
{elseif $item_type === "updated"}

	{include "$themePath/sitograph/fields/field-updated.tpl"}
	
{elseif $item_type === "lang"}

	{include "$themePath/sitograph/fields/field-lang.tpl"}
	
{elseif $item_type === "bool" || $item_type === "published" || $item_type === "deleted"}

	{include "$themePath/sitograph/fields/field-bool.tpl"}
	
{elseif $item_type === "date"}

	{include "$themePath/sitograph/fields/field-date.tpl"}

{elseif $item_type === "select"}

	{include "$themePath/sitograph/fields/field-select.tpl"}
	
{elseif $item_type === "file"}

	{include "$themePath/sitograph/fields/field-file.tpl"}
	
{elseif $item_type === "pic"}

	{include "$themePath/sitograph/fields/field-picture.tpl"}
	
{elseif $item_type === "multiselect"}

	{include "$themePath/sitograph/fields/field-multiselect.tpl"}
	
{else}

	{include "$themePath/sitograph/fields/field-default.tpl"}
	
{/if}
{if !($item_type === "pic" || $item_type ==="doc" || $item_type ==="text")}
    <label for="i{$item_id}" class="col-sm-6 control-label">
    
    {if $item_name}{_t("table.$admin_table.$item_name")}{/if}
    
    
    <small class="text-muted" style="color:#fff;">
	{$t["type.$item_type"]}
	</small>
    </label>
{/if}
</div>


{else}
empty item_id $item_name:{$item_name}
{/if}