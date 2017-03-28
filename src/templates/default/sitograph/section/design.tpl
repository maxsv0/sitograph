{if $admin_designs}

{foreach from=$admin_designs name=loop key=design_name item=info}
<div class="row">

<div class="col-sm-10">

<h3>{$info.title} <small>{$design_name} v. {$info.version}</small>{if $theme_active == $design_name} <span class="badge">Active</span>{/if}</h3>
<p class="text-right">
</p>


<p>{$info.description}</p>

</div>


<div class="col-sm-2">
<p>{$info.date}</p>

{if $theme_active !== $design_name}
<p><a href="/admin/?section=design&design_activate={$design_name}" class="btn btn-primary">Activate</a></p>
{else}
<p class="text-success"><b>activated</b></p>
{/if}

<p><a href="/admin/?section=design&config" class="btn btn-primary">Settings</a></p>

</div>


</div>



<hr>
{/foreach}


{if $theme_config_show}
<div class="row">

{foreach from=$theme_config name=loop key=name item=item}

<div class="form-group">
<label class="control-label col-sm-5" for="email">{$item.name}</label>
<div class="col-sm-4">
  <input type="test" class="form-control" readonly id="config_{$name}" value="{$item.value}">
</div>
<div class="col-sm-3">
  <a href="/admin/?section=site_settings&edit_key={$name}" class="btn btn-primary">Edit</a>
</div>
</div>

{/foreach}

</div>
{/if}




{/if}