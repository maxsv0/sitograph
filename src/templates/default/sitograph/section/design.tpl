{if $admin_designs}

<div class="well well-lg">
<div class="row">
  <h4 class="col-sm-12">{_t("title.customize_design_settings")}</h4>

{foreach from=$theme_config name=loop key=name item=item}
  <div class="form-group">
    <label class="control-label col-sm-3" for="email">{$item.name}</label>
    <div class="col-sm-8">
      <input type="test" class="form-control" readonly id="config_{$name}" value="{$item.value}">
    </div>
    <div class="col-sm-1">
      <a href="/admin/?section=site_settings&edit_key={$name}" class="btn btn-primary">{_t("btn.edit")}</a>
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
      <p><a href="/admin/?section=design&design_activate={$design_name}" class="btn btn-primary">Activate</a></p>
    {else}
      <p class="text-success"><b>activated</b></p>
    {/if}
</div>


</div>
{/foreach}






{/if}