<div class="col-sm-12">

{foreach from=$value key=valueID item=valueData name=loop}
    <input type="text" class="form-control" value="{$valueData}" name="{$form_id}_{$item_id}[]" >
{/foreach}

    <small><a href="#">add new</a></small>
</div>