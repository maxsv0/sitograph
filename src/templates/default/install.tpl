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

<div style="padding:50px 100px 0px 100px;">
<h2 style="color:#bebebe;text-align:center;">Sitograph CMS</h2>
<div style="background:#fff;padding:20px 30px 5px 30px;max-width:800px;margin:0 auto;">
<form style="text-align:center;" method="POST">



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

	<p>
	<h1>Welcome to Sitograph installation wizard.</h1>
	</p>

	<p>
	<input type="submit" value="Start installation" style="font-size:36px;">  
	<input type="hidden" name="install_step" value="2">  
	</p>

{elseif $install_step === 2}
<p>
Before getting started, we need to setup <b>config.php</b> in the root directory.<br>
Sample config <b>config-sample.php</b> is being used right now.
</p>

<table width="100%" cellpadding="5" cellspacing="0">
{foreach from=$configList key=configName item=configValue}
{if $configName === "LANGUAGES"}
<tr valign="top">
	<td align="right" width="45%">Select Languages:</td>
	<td align="left">
{foreach from=$languages item=langID} 
<input type="checkbox" name="msv_LANGUAGES[]" checked value="{$langID}"> {$langID}
&nbsp;&nbsp;
{/foreach} 
	</td>
</tr>
{else}
<tr valign="top">
	<td align="right" width="45%">{$configName}</td>
	<td align="left">
	<input type="text" name="msv_{$configName}" value="{$configValue}" style="width:95%;">
	</td>
</tr>
{/if}
{/foreach}



</table>
	
	<p>
	<input type="submit" value="Continue" style="font-size:26px;">  
	<input type="hidden" name="install_step" value="3">  
	</p>
	
	
{elseif $install_step === 3}


<h2>Install modules</h2>

<p>
Once you press "Continue" button each of modules will be installed.<br>
Installation process includes creation of database tables and default website structure.
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

<h2>Create Administrator account</h2>

<table width="90%">
<tr>
	<td width="50%" align="right">
		<input type="checkbox" name="admin_create" id="iadmin_create" value="1" checked>
	</td>
	<td align="left">
		<label for="iadmin_create">Add Administrator account</label> 
	</td>
</tr>
<tr>
	<td width="50%" align="right">Administrator Email</td>
	<td>
		<input type="text" style="width:100%;" name="admin_login" value="{$admin_login}">
	</td>
</tr>
<tr>
	<td align="right">Administrator Password</td>
	<td>
		<input type="text" style="width:100%;" name="admin_password" value="{$admin_password}">
	</td>
</tr>
</table>

<p>
<b>Note!</b> Administrator will receive email once account is created.
</p>

	<p>
	<input type="submit" value="Continue" style="font-size:26px;">  
	<input type="hidden" name="install_step" value="4">  
	</p>
	

{elseif $install_step === 4}



<h1>Congratulations! Installation successful!</h1>


	<p>
	<input type="submit" value="Reload page to start using website" style="font-size:26px;">  
	<input type="hidden" name="install_step" value="5">  
	</p>


{else}


something went wrong



{/if}




</form>


<p>
Step: {$install_step}
</p>

</div>



{if $install_step > 1}
<p>
<form method="POST">
<input type="submit" value="Reset installation" name="install_reset">  
<input type="hidden" name="install_step" value="1">  
</form>
</p>
{/if}


</div>	

<h4 style="color:#bebebe;text-align:center;">
<a href='http://sitograph.com/' style="color:#bebebe;">Sitograph 5.2</a> 
developed using 
<a href='http://doc.msvhost.com/' style="color:#bebebe;">MSV Framework 1.0</a></h4>

{$htmlFooter}

</body>
</html>