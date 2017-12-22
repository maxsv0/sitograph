<div class="col-sm-12">


<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
{foreach from=$admin_module_locales name=loop key=moduleName item=localeList}
{if $smarty.foreach.loop.first}
	<li role="presentation" {if !$locales_active}class="active"{/if}><a href="#module-{$moduleName}" aria-controls="module-{$moduleName}" role="tab" data-toggle="tab">{$moduleName}</a></li>
{else}
	<li role="presentation" {if $locales_active == $moduleName}class="active"{/if}><a href="#module-{$moduleName}" aria-controls="module-{$moduleName}" role="tab" data-toggle="tab">{$moduleName}</a></li>
{/if}
{/foreach}
  </ul>

<!-- Tab panes -->
<div class="tab-content">
{foreach from=$admin_module_locales name=loop key=moduleName item=localeList}
{if $smarty.foreach.loop.first}
	<div role="tabpanel" class="tab-pane {if !$locales_active}active{/if}" id="module-{$moduleName}">
{else}
	<div role="tabpanel" class="tab-pane {if $locales_active == $moduleName}active{/if}" id="module-{$moduleName}">
{/if}



<table class="table table-hover table-module">
<tr>
<th>Language</th>
<th>{$t["admin.locale_param"]}</th>
<th>{$t["admin.locale_value"]}</th>
<th>{$t["actions"]}</th>
</tr>

{foreach from=$localeList key=localeID item=localeText}

<tr data-id="{$localeID}">
<td>{LANG}</td>
<td>{$localeID}</td>
<td>{$localeText}</td>
<td class="text-nowrap">
	<a href="{$lang_url}/admin/?section={$admin_section}&delete={$localeID}&form_module={$moduleName}" title="{$t['btn.delete']}" class="btn btn-danger" onclick="if (!confirm('{$t["btn.remove_confirm"]}')) return false;"><span class="glyphicon glyphicon-remove"></span></a>
	<a href="{$lang_url}/admin/?section={$admin_section}&edit={$localeID}&module={$moduleName}" title="{$t['btn.edit']}" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
</td>
</tr>

{/foreach}

</table>





	</div>
{/foreach}
</div>

</div>



<div class="col-sm-6">
<a href="{$lang_url}/admin/?section={$admin_section}&add_new" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span>{$t["btn.add_new"]}</a>
</div>



