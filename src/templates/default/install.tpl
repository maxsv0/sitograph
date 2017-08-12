<!DOCTYPE html>
<html lang="{LANG}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{$page.title}</title>
	<meta name="keywords" content="{$page.keywords}">
	<meta name="description" content="{$page.description}">

    {$htmlHead}
</head>
<body bgcolor="F7F7F7">

<div class="container" style="padding:25px;">
	<h2 style="color:#333746;text-align:center;margin:10px 0;">Sitograph CMS</h2>
	<div class="well" style="min-height:400px; position: relative;">
		<form class="form-horizontal" method="POST">


            {if $message_error}
				<div class="alert alert-danger fade in alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    {$message_error}
				</div>
            {/if}

            {if $message_success}
				<div class="alert alert-success fade in alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    {$message_success}
				</div>
            {/if}


            {if $install_step === 1}

			<h1 class="text-center" style="margin:50px 0 75px 0;">Welcome to Sitograph Installation Wizard</h1>

			<p class="text-center">
				<input type="submit" value="Start installation" class="btn btn-lg btn-primary">
				<input type="hidden" name="install_step" value="2">
			</p>

            {elseif $install_step === 2}
			<p>
				Before getting started, we need to setup <b>config.php</b> in the root directory.
				Sample config <b>config-sample.php</b> is being used when config.php is not present.
			</p>
			<br>
            {foreach from=$configList key=configName item=configValue name=loop}
            {if $smarty.foreach.loop.index >= 5}
				<div class="form-group collapse" style="margin-bottom: 10px;">
            {else}
				<div class="form-group" style="margin-bottom: 10px;">
            {/if}
					<label for="imsv_{$configName}" class="col-sm-4 control-label">{$configName}</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="msv_{$configName}" id="imsv_{$configName}" value="{$configValue}" style="width:95%;">
					</div>
				</div>
                {/foreach}

				<p class="text-right">
					<a href="#" data-toggle="collapse" data-target=".form-group.collapse">More settings</a>
				</p>

				<p class="text-center">
					<input type="submit" value="Continue" class="btn btn-lg btn-primary">
					<input type="hidden" name="install_step" value="3">
				</p>

                {elseif $install_step === 3}


				<h3 class="text-center">Install modules</h3>

				<p>
					Once you press "<b>Continue</b>" each of modules will be installed.
					Installation process includes creation of database tables and default website content.
				</p>

				<div>

					<h5>Local modules to be installed:</h5>
					<p class="well well-sm" style="background: #fff;">
                        {foreach from=$modulesList key=moduleName item=moduleInfo}
							<span style="margin-right:10px;">
								<input type="checkbox" name="modules_local[]" checked value="{$moduleName}">&nbsp;{$moduleName}
							</span>
                        {/foreach}
					</p>

					<h5>Remote modules to be installed:</h5>
					<p class="well well-sm" style="background: #fff;margin-bottom:5px;">
                        {foreach from=$modulesListRemote item=moduleName}
							<input type="checkbox" name="modules_remote[]" checked value="{$moduleName}">
                            {$moduleName}<br>
                        {foreachelse}
							<i>no modules selected</i>
                        {/foreach}
					</p>
					<p>
						Type modules to add separated with comma:
						<input type="text" size="50" name="modules_remote_str">
						<a href="{REP}" class="btn btn-default btn-sm">Browse</a>
					</p>
				</div>

				<h3 class="text-center">Create Administrator account</h3>

				<div class="form-group">
					<div class="col-sm-offset-5 col-sm-7">
						<div class="checkbox">
							<label for="admin_create">
								<input type="checkbox" id="admin_create" name="admin_create" value="1" checked> Create Administrator account
							</label>
							<br>
							<label for="admin_notify">
								<input type="checkbox" id="admin_notify" name="admin_notify" value="1"> Send email notification
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="iadmin_login" class="col-sm-5 control-label">Administrator Email</label>
					<div class="col-sm-7">
						<input type="email" class="form-control" id="iadmin_login" name="admin_login" value="{$admin_login}" placeholder="Email">
					</div>
				</div>

				<div class="form-group">
					<label for="iadmin_password" class="col-sm-5 control-label">Administrator Password</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="iadmin_password" name="admin_password" value="{$admin_password}">
					</div>
				</div>

				<p class="text-center">
					<input type="submit" value="Continue" class="btn btn-lg btn-primary">
					<input type="hidden" name="install_step" value="4">
				</p>

                {elseif $install_step === 4}

				<h1 class="text-center" style="margin:50px 0 75px 0;">Congratulations! Installation was successful.</h1>

                {foreach from=$settings item=config name=loop}
					<div class="form-group collapse">
						<label for="is_{$config['param']}" class="col-sm-4 control-label">{$config['param']}</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="s_{$config['param']}" id="is_{$config['param']}" value="{$config['value']}" style="width:95%;">
						</div>
					</div>
                {/foreach}
				<p class="text-right">
					<a href="#" data-toggle="collapse" data-target=".form-group.collapse">Configure Website settings</a>
				</p>

				<p class="text-center">
					<input type="submit" value="Reload page and start using Website" class="btn btn-lg btn-primary">
					<input type="hidden" name="install_step" value="5">
				</p>

                {else}

				something went wrong

                {/if}

		</form>

		<div style="position: absolute; bottom:10px;">
			<div class="text-muted" style="float:left;width:80px;line-height:23px;">Step: {$install_step} / 4</div>
            {if $install_step > 1}
				<form method="POST" style="float:left;width:150px;line-height:23px;">
					<input type="submit" value="Reset" name="install_reset" class="btn btn-danger btn-xs">
					<input type="hidden" name="install_step" value="1">
				</form>
            {/if}
		</div>
	</div>



</div>

<h4 style="color:#bebebe;text-align:center;">
	<a href='http://sitograph.com/' target="_blank">Sitograph 1.0.beta</a>
	using
	<a href='http://doc.msvhost.com/' target="_blank">MSV Framework 1.1</a></h4>

{$htmlFooter}

</body>
</html>