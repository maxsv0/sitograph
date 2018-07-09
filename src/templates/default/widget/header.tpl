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
<body>

<div class="container header">
    <div class="row">
		<div class="col-sm-6">
			{if $search}
			<form action="{$lang_url}{$search.baseUrl}?search" method="post" class="form-inline">
				<div class="form-group">
					<input type="text" name="keyword" class="form-control" value="{$search_str}" placeholder="{_t("form.search_lable")}"/>
				</div>
				<button type="submit" value="search" class="btn btn-sm">{_t("btn.search")}</button>
			</form>
			{/if}
		</div>
    	<div class="col-sm-6">
	        <div class="row">
	        <div class="col-xs-4">
	    <p>

				<a href="/sitemap/">
					Sitemap
				</a>
			 {if $feedback}
				 &nbsp;&nbsp;
				 <a href="{$feedback.baseUrl}">
					 Feedback
				 </a>
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
	     	
	        <div class="col-xs-8">
	     	{include file="$themePath/widget/menu-user.tpl"}
	     	</div>
	     	
	     	
	        </div>
	        
        </div>
 	</div>
       
</div>
