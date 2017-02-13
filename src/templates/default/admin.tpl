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
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      
      
      
      <ul class="nav navbar-nav navbar-left">
      <li style="width:180px;"><a class="navbar-brand" href="{$lang_url}/admin/">
      <img src="{$content_url}/images/msv-logo.png"/>
      </a>
      </li>
      
      <li>
<a href="#" data-toggle="collapse" data-target="#navnotif">notif. 
{if $admin_notifications_count}
<span class="badge">{$admin_notifications_count}</span> 
{/if}
<span class="caret"></span>
</a>

<div id="navnotif" class="collapse">
{if $admin_notifications}
{$admin_notifications}
{else}
<div class="alert alert-info">You dont have any notifications</div>
<p class="text-center">
<a href="#">refresh</a>
</p>
{/if}

</div>  


      </li>

      
      <li>
      <a href="#" data-toggle="collapse" data-target="#navwebsite">{$host} <span class="caret"></span></a>
<ul id="navwebsite" class="nav collapse">
{foreach from=$languages item=langID}
{assign var="link" value=$home[$langID]}
<li><a href="{$link}">{$link}</a></li>
{/foreach} 
</ul>
      </li>
        
      <li>
      <a href="{$home_url}">{_t("btn.goto")} {$host}</a>
      </li>
        
      </ul>
      
      
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#" data-toggle="collapse" data-target=".sidebar"><span class="glyphicon glyphicon-th-list"></span></a></li>
        
      </ul>
      <form class="navbar-form navbar-right">
        <input type="text" class="form-control" placeholder="Search...">
      </form>
    </div>
  </div>
</nav>
    
<div class="container-fluid">
<div class="row">
<div class="col-sm-3 col-md-2 sidebar collapse in">

{if $user.id}
<p class="text-right" data-toggle="collapse" data-target="#navuser">
<b>{$user.email}</b> 
<span class="caret"></span>
</a>

<ul id="navuser" class="nav collapse">
<li><a href="{$lang_url}/admin/?section=users&table=users&edit={$user.id}">Edit profile</a></li>
<li><a href="{$user_logout_url}">Logout</a></li>
</ul>

</p>
{/if}


  <ul class="nav nav-sidebar">

{foreach from=$admin_menu key=menu_id item=item}

{if $item.submenu}

{if $admin_menu_active == $menu_id}
	<li class="active"><a href="#" data-toggle="collapse" data-target="#submenu-{$menu_id}">{$item.name} <span class="sr-only">(current)</span><span class="pull-right subplus"></span></a></li>
<ul class="nav nav-sidebar2 collapse in" id="submenu-{$menu_id}">
{else}
	<li><a href="#" data-toggle="collapse" data-target="#submenu-{$menu_id}">{$item.name} <span class="sr-only">(current)</span><span class="pull-right subplus"></span></a></li>
<ul class="nav nav-sidebar2 collapse" id="submenu-{$menu_id}">
{/if}

{foreach from=$item.submenu key=submenu_id item=subitem}
{if $admin_submenu_active == $submenu_id}
<li class="active"><a href="{$lang_url}{$subitem.url}">{$subitem.name}</a></li>
{else}
<li><a href="{$lang_url}{$subitem.url}">{$subitem.name}</a></li>
{/if}
{/foreach}
</ul>
{else}
	{if $item.url}
	
		{if $admin_menu_active == $menu_id}
			<li class="active"><a href="{$lang_url}{$item.url}">{$item.name} <span class="sr-only">(current)</span></a></li>
		{else}
			<li><a href="{$lang_url}{$item.url}">{$item.name}</a></li>
		{/if}
	
	{/if}
{/if}
{/foreach}  
    
  </ul>
  
</div>
<div class="col-sm-9 col-md-10 col-md-offset-2 col-sm-offset-3 main">
<h2 class="sub-header">{$admin_menu_item.title}</h2>


{include file="$themePath/widget/navigation.tpl" navigation=$navigation_admin}



{include file="$themePath/widget/messages.tpl"}
{if $admin_menu_item.file}
{assign var="filename" value="`$themePath`/admin/section/`$admin_menu_item.file`"}
{include file="$filename"}
{/if}

  
  </div>
  
  
  
  
</div>
</div>
</div>