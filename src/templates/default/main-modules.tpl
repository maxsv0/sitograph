{include file="$themePath/widget/header.tpl"}

<div class="container top-menu">
	<div class="row">
        {include file="$themePath/widget/menu-top.tpl"}
	</div>
</div>

{include file="$themePath/widget/navigation.tpl"}

<div class="container">
	<div class="row content-block">
		<!-- page document header -->
        {if $document.name}
			<div class="col-lg-12"><h1>{$document.name}</h1></div>
        {/if}
		<!-- page document -->
		<div class="col-lg-8 col-md-7 col-sm-12">

<h3>Sitograph Modules</h3>
<p>
	Repository link is configured in <code>config.php</code>.
</p>
<p>
	Catalog of modules together with detailed description can be found at repository website.
</p>
<p class="well text-center">
	<a href="{$rep_url}" target="_blank">{$rep_url}</a>
    {if $rep_status == "online"}
		<span class='label label-success'>online</span>
    {else}
		<span class='label label-danger'>offline</span>
    {/if}
</p>
			<div class="row">
				<div class="col-md-6">
					<h3>Installed Modules</h3>
<pre>
$website
{foreach from=$modules_installed_list item=$moduleName}
| {$moduleName}
{/foreach}
</pre>
				</div>
				<div class="col-md-6">
					<h3>Activated (on this page)</h3>
<pre>
$website
{foreach from=$modules_active_list item=$moduleName}
| {$moduleName}
{/foreach}
</pre>
				</div>
			</div>
			<h3>Top 20 of avaliable modules</h3>
<table class="table">
	<tr>
		<th>Name</th>
		<th>Version</th>
		<th>Downloads</th>
		<th>Description</th>
		<th>Installed</th>
	</tr>
{foreach from=$modules_list key=$moduleID item=$module}
	<tr>
		<td>{$module.title}</td>
		<td>{$module.version}</td>
		<td>{$module.downloads}</td>
		<td>{$module.description}</td>
		<td>
			{if in_array($moduleID, $modules_installed_list)}
				<span class="label label-success">installed</span>
			{else}
				not installed
			{/if}
		</td>
	</tr>
{/foreach}
</table>

			<br>


		</div>
		<!-- sideblock -->
		<div class="col-lg-4 col-md-5 hidden-sm">
            {include file="$themePath/widget/sideblock.tpl"}
		</div>
	</div>
</div>


{include file="$themePath/widget/footer.tpl"}