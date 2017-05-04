<!DOCTYPE html>
<html lang="en">
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

<div class="container" style="padding:50px 100px 0px 100px;">
<h2 style="color:#bebebe;text-align:center;">Sitograph CMS</h2>
<div class="well">
<form class="form-horizontal" method="POST">



{if $message_error}
<div style="border:1px solid #f00;padding:15px;color:#500;">
{$message_error}
</div>
{/if}

{if $message_success}
<div style="border:1px solid #0f0;padding:15px;color:#050;">
{$message_success}
</div>
{/if}


{if $install_step === 1}

	<p class="text-center">
	<h1>Welcome to Sitograph installation wizard</h1>
	</p>

	<p class="text-center" style="margin:50px 0;">
	<input type="submit" value="Start installation" class="btn btn-lg btp-primary">  
	<input type="hidden" name="install_step" value="2">  
	</p>

{elseif $install_step === 2}
<p class="lead">
Before getting started, we need to setup <b>config.php</b> in the root directory.<br>
Sample config <b>config-sample.php</b> is being used when config.php is not present.
</p>

{foreach from=$configList key=configName item=configValue name=loop}
{if $smarty.foreach.loop.index >= 5}
<div class="form-group collapse">
{else}
<div class="form-group">
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
	<input type="submit" value="Continue" class="btn btn-lg btp-primary">  
	<input type="hidden" name="install_step" value="3">  
	</p>
	
	
{elseif $install_step === 3}


<h2 class="text-center">Install modules</h2>

<p class="lead">
Once you press "<b>Continue</b>" each of modules will be installed.<br>
Installation process includes creation of database tables and default website.
</p>

<div>

<div style="text-align:left;float:left;width:50%;">
<p><u>Local modules to install</u>: </p>
{foreach from=$modulesList key=moduleName item=moduleInfo} 
<input type="checkbox" name="modules_local[]" checked value="{$moduleName}">
{$moduleName}<br>
{/foreach}
</div>


<div style="text-align:left;float:left;width:50%;">
<p><u>Remote modules to install</u>: </p>
{foreach from=$modulesListRemote item=moduleName} 
<input type="checkbox" name="modules_remote[]" checked value="{$moduleName}">
{$moduleName}<br>
{/foreach}
</div>

</div>

<br style="clear:both;">

<hr>

<h2 class="text-center">Create Administrator account</h2>


<div class="form-group">
<div class="col-sm-offset-5 col-sm-7">
  <div class="checkbox">
    <label>
      <input type="checkbox" name="admin_create" value="1" checked> Add Administrator account
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

<p class="text-info">
<b>Note!</b> Administrator will receive email once account is created.
</p>

	<p class="text-center">
	<input type="submit" value="Continue" class="btn btn-lg btp-primary">  
	<input type="hidden" name="install_step" value="4">  
	</p>
	

{elseif $install_step === 4}



<h1>Congratulations! Installation successful!</h1>


	<p class="text-center">
	<input type="submit" value="Reload page to start using website" class="btn btn-lg btp-primary">  
	<input type="hidden" name="install_step" value="5">  
	</p>


{else}


something went wrong



{/if}




</form>


<p class="text-muted">
Step: {$install_step}
</p>

</div>



{if $install_step > 1}
<p>
<form method="POST">
<input type="submit" value="Reset installation" name="install_reset" class="btn btn-danger">  
<input type="hidden" name="install_step" value="1">  
</form>
</p>
{/if}


</div>	

<h4 style="color:#bebebe;text-align:center;">
<a href='http://sitograph.com/' target="_blank">Sitograph 5.2</a> 
developed using 
<a href='http://doc.msvhost.com/' target="_blank">MSV Framework 1.0</a></h4>

{$htmlFooter}

</body>
</html>