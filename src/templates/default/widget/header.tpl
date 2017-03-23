<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>{$page.title}</title>
	<meta name="keywords" content="{$page.keywords}"/>
	<meta name="description" content="{$page.description}"/>

    {$htmlHead}
  </head>
<body {if $theme_bg}style="background: url({$theme_bg}) top center no-repeat #FFF;"{/if}>

<div class="container header">
    <div class="row">
		<div class="col-md-4">
			<div class="phone-block">
 		       <table cellpadding="0" cellspacing="0" width="170" style="margin-top:15px">
				<tr>
					<td style="padding-right: 10px;"><img src="{$content_url}/images/pic_tel.gif" width="14" height="14" alt="Контактные телефоны"></td>
					<td style="font-size: 13px; white-space: nowrap; color: #FFF;">
					+380 (44) 536-00-66<br/>
					+380 (93) 898-33-70
					</td>
				</tr>
				</table>
            </div>  
		</div>
		<div class="col-md-4">
			<div class="search-block">
				<form action="{$lang_url}/search/?search" method="post">
					<input type="text" name="keyword" value="{$search_str}" placeholder="найти"/>
					<button type="submit" value="search"></button>
				</form>
			</div>
		</div>
    	<div class="col-md-4">
	        <div class="login-block">
	     	{include file="$themePath/widget/menu-user.tpl"}
	        </div>
	        
	        <div class="header-menu">
				<a href="/sitemap/" class="sitemap-ico"></a>
				<span class="top-delimiter"></span>
				<a href="/contacts/" class="mail-ico"></a>
				<span class="top-delimiter"></span>
				<a href="http://localhost/" class="top-lang">en</a>
				<a href="http://ua.localhost/" class="top-lang">ua</a>
				<a href="http://ru.localhost/" class="top-lang">ru</a>
			</div>
        </div>
 	</div>
       
</div>
