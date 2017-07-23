<!DOCTYPE html>
<html lang="{LANG}">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title>{$page.title}</title>
	<meta name="keywords" content="{$page.keywords}"/>
	<meta name="description" content="{$page.description}"/>
	{$htmlHead}
</head>
<body {if $theme_bg}style="background: url({$theme_bg}) #FFF;"{/if}>

<div class="container header">
    <div class="row">
		<div class="col-sm-4">
			<div class="phone-block">
				{if $theme_header_contacts}
 		       <table cellpadding="0" cellspacing="0" width="170" style="margin-bottom:15px">
				<tr>
					<td style="padding-right: 10px;">
					<span class="glyphicon glyphicon-earphone" style="color: #FFF;"></span>
					</td>
					<td style="font-size: 13px; white-space: nowrap; color: #FFF;">
                        {$theme_header_contacts}
					</td>
				</tr>
				{/if}
				</table>
            </div>
		</div>
		<div class="col-sm-4">
			<div class="search-block">
				{if $search}
				<form action="{$lang_url}{$search.baseUrl}?search" method="post">
					<input type="text" name="keyword" class="input-sm" value="{$search_str}" placeholder="{_t("form.search_lable")}"/>
					<button type="submit" value="search" class="btn btn-sm">{_t("btn.search")}</button>
				</form>
				{/if}
			</div>
		</div>
    	<div class="col-sm-4">
	        <div class="row">
	        <div class="col-xs-4 header-menu">
	    <p>
				
				<a href="/sitemap/" class="sitemap-ico"></a>
				<span class="top-delimiter"></span>
			 {if $feedback}
				<a href="{$feedback.baseUrl}" class="mail-ico"></a>
				<span class="top-delimiter"></span>
			 {/if}
		</p>
				
{if $languages|count > 1}
<p class="top-lang">
{foreach from=$languages item=langID} 
{assign var="link" value=$home[$langID]}
<a href="{$link}"> {$langID}</a>
{/foreach} 
</p>
{/if} 
	     	</div>
	     	
	        <div class="col-xs-8 login-block">
	     	{include file="$themePath/widget/menu-user.tpl"}
	     	</div>
	     	
	     	
	        </div>
	        
        </div>
 	</div>
       
</div>
