{if $admin_designs}
<div class="alert hide" id="submit_status"></div>

<div class="well">
<div class="row">
  <h4 class="col-sm-12">{_t("title.customize_design_settings")}</h4>

{foreach from=$theme_config name=loop key=name item=item}
  <div class="form-group clearfix">
    <label class="control-label col-sm-3" for="config_{$name}">{$item.name}</label>
    <div class="col-sm-7">
      <input type="test" class="form-control" id="config_{$name}" value="{$item.value}">
    </div>
    <div class="col-sm-2">
      <a href="{$lang_url}{$admin_url}?section=site_settings&edit_key={$name}" onclick="list_toggle_submit('site_settings','{TABLE_SETTINGS}','{$item.id}','value',$('#config_{$name}').val());return false;" class="btn btn-block btn-primary">{_t("btn.save")}</a>
    </div>
  </div>
{/foreach}

</div>
</div>


{foreach from=$admin_designs name=loop key=design_name item=info}
<div class="row">

<div class="col-sm-2">
<img src="{CONTENT_URL}/{$info.preview}" class="img-responsive">
</div>
<div class="col-sm-6">

<h3>{$info.title}</h3>
<h4>{$design_name} v.{$info.version}</h4>

<p>{$info.description}</p>
</div>


<div class="col-sm-2">
  <p>{$info.date}</p>
</div>

<div class="col-sm-2">
    {if $theme_active !== $design_name}
      <p><a href="{$lang_url}{$admin_url}?section=design&design_activate={$design_name}" class="btn btn-primary">{_t("admin.activate")}</a></p>
    {else}
      <p class="text-success"><b>{_t("admin.activated")}</b></p>
    {/if}
</div>


</div>
{/foreach}






{/if}