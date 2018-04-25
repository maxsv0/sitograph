<html>

<head>
<title>{_t("cms")}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

<link rel="stylesheet" type="text/css" href="{$contentUrl}/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="{$contentUrl}/css/sitograph.css" />

<script src="{$contentUrl}/js/jquery.min.js"></script>
<script src="{$contentUrl}/js/default.js"></script>
<script src="{$contentUrl}/js/bootstrap.min.js"></script>

<link href="/favicon.ico" rel="shortcut icon">
</head>


<body style="background: url({$contentUrl}/images/sitograph/bg.gif) repeat-x #FFFFFF;padding-top:10px;">




<table align="center" cellpadding="0" cellspacing="0" width="940" height="100%">
<tr>
	<td valign="top" width="139">
	&nbsp;
	</td>
	<td>
	
	
	<table align="center" cellpadding="0" cellspacing="0" width="326">
	<tr>
		<td style="padding-bottom: 50px;" align="center">
		<p>
			<img src="{$contentUrl}/images/sitograph/sitograph-logo-dark-{if $lang == "ru" || $lang == "ua"}ru{else}en{/if}.png" style="height:80px;">
		</p>
		<h4>{_t("cms")}</h4>
		</td>
	</tr>
	<tr>
		<td style="padding: 0px 0px 10px 20px; font-size: 14px;">

{if $message_error}
<span style="color: #EE1A3B;">{$message_error}</span>
{else}
	{_t("form.wellcome")}
{/if}
		
		</td>
	</tr>
	<tr>
		<td style="background: url({$contentUrl}/images/sitograph/login_plain.png) 0 0 no-repeat; padding: 1px 3px 5px 3px;" height="206">
		
<form action="/admin/login/" method="POST" id="login_form">
		<table align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td style="padding: 5px 0;">{_t("form.login")}</td>
		</tr>
		<tr>
			<td style="padding: 5px 0;"><input class="login_form" type="text" name="email" value="" style="width: 280px;"></td>
		</tr>
		<tr>
			<td style="padding: 10px 0 5px;">{_t("form.password")}</td>
		</tr>
		<tr>
			<td style="padding: 5px 0 15px;"><input class="login_form" type="password" name="password" value="" style="width: 280px;"></td>
		</tr>
		<tr>
			<td><input type="submit" class="loginbtn" value="{_t("btn.login")}"></td>
		</tr>
		</table>
<input type="hidden" name="doLogin" value="1">
</form>
		
		</td>
	</tr>
	</table>
	
	
	</td>
	<td width="139">
	</td>
</tr>
</table>







{$htmlFooter}

</body>
</html>