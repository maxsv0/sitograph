<div class="col-sm-4">
  <input type="file" class="form-control" id="i{$item_id}" placeholder="{$item_id}" name="{$form_id}_{$item_id}" >
</div>


{if $value}
<div class="col-sm-8">
    <a class="btn" href="{CONTENT_URL}/{$value}">{$value}<span class="glyphicon glyphicon-download-alt"></span></a>
</div>
{/if}



<p class="col-sm-12">
    {_t("form.file")}
    <input type="text" class="form-control form-control-text" name="{$form_id}_{$item_id}" id="path-{$item_id}" value="{$value}" {if $readonly}readonly{/if} placeholder="{_t("msg.no_stored_file")}">

    {if !$readonly}
        {if $value}
            <input type="button" class="btn btn-danger btn-xs" value="{_t("btn.remove_link")}" onclick="removeLink('{$item_id}');">
        {/if}
    {/if}
</p>