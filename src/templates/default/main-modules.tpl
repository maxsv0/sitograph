{include file="$themePath/widget/header.tpl"}

<div class="container top-menu">
	<div class="row">
        {include file="$themePath/widget/menu-top.tpl"}
	</div>
</div>

{include file="$themePath/widget/navigation.tpl"}

<div class="container">
	<div class="row content-block">
		<!-- page document -->
		<div class="col-lg-12">
            {if $document.name}
				<h1>{$document.name}</h1>
            {/if}

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
			<h3>Top 20 of available modules</h3>

			<div class="row">
                {foreach from=$modules_list key=$moduleID item=$module}
					<div class="col-sm-4">
                        {include file="$themePath/widget/module.tpl"}
					</div>
                {/foreach}
			</div>

            {include file="$themePath/widget/module-modal.tpl"}


		</div>

	</div>
</div>


{include file="$themePath/widget/footer.tpl"}