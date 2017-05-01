<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$page.title}</title>
	<meta name="keywords" content="{$page.keywords}">
	<meta name="description" content="{$page.description}">
  </head>
<body style="background-color:#333746;">
<style>
{literal}
h1,h2 {color:#74c4d4;}
{/literal}
</style>

<table align="center" height="100%" width="600" cellpadding="0" cellspacing="0" style="min-height:600px;">
<tr>
<td align="left" valign="middle">

{if $document.name}
<h1>{$document.name}</h1>
{/if}
	
{if $document}
{$document.text}
{/if}
		
</td>
</tr>
</table>

</body>
</html>