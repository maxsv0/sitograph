
<html>

<head>
<title>Панель управления</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

<link rel="stylesheet" type="text/css" href="{$content_url}/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="{$content_url}/css/admin-mcg.css" />

<script src="{$content_url}/js/jquery.min.js"></script>
<script src="{$content_url}/js/default.js"></script>
<script src="{$content_url}/js/bootstrap.min.js"></script>

</head>


<body style="background: url({$content_url}/images/adminmcg/bg.gif) repeat-x #FFFFFF;padding-top:10px;">




<table align="center" cellpadding="0" cellspacing="0" width="940" height="100%">
<tr>
	<td valign="top" width="139">
	<img src="{$content_url}/images/adminmcg/logo-new.png">
	</td>
	<td>
	
	
	<table align="center" cellpadding="0" cellspacing="0" width="326">
	<tr>
		<td style="padding-bottom: 100px;"><img src="{$content_url}/images/adminmcg/index_text.png"></td>
	</tr>
	<tr>
		<td style="padding: 0px 0px 10px 20px; font-size: 14px;">

{if $message_error}
<span style="color: #EE1A3B;">{$message_error}</span>
{else}
	представьтесь, пожалуйста —
{/if}
		
		</td>
	</tr>
	<tr>
		<td style="background: url({$content_url}/images/adminmcg/login_plain.png) 0 0 no-repeat; padding: 1px 3px 5px 3px;" height="206">
		
<form action="/admin/login/" method="POST" id="login_form">
		<table align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td style="padding-bottom: 4px;">Логин</td>
		</tr>
		<tr>
			<td style="padding-bottom: 11px;"><input class="login_form" type="text" name="email" value="" style="width: 280px;"></td>
		</tr>
		<tr>
			<td style="padding-bottom: 4px;">Пароль</td>
		</tr>
		<tr>
			<td style="padding-bottom: 37px;"><input class="login_form" type="password" name="password" value="" style="width: 280px;"></td>
		</tr>
		<tr>
			<td><input type="image" style="height:30px;" src="{$content_url}/images/adminmcg/btn_login.gif"></td>
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