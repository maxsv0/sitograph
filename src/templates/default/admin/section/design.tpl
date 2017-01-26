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
</div>


</div>



<hr>
{/foreach}

{/if}