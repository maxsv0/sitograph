<!DOCTYPE html>

<head>
<title>{$admin_title_page}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>

{$htmlHead}

</head>



<body bottommargin="0" leftmargin="0" marginheight="0" marginwidth="0" rightmargin="0" topmargin="0">


<table cellpadding="0" cellspacing="0" width="100%" height="100%">
<tr>
	<td height="1">
	
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr valign="bottom" bgcolor="#000000">
    
		<td height="25">
		<div style="padding-bottom: 4px; padding-left: 10px; font-size: 10px; color: #4F4F4F;">{$admin_title}</div>
		</td>
		<td width="400">
		<div style="padding-bottom: 4px; font-size: 11px; color: #D9D9D9;">{_t("admin.logged_as")} {$user.email}</div>
		</td>
		<td width="300">
		<div style="padding-bottom: 4px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td>&nbsp;</td>
			<td align="right"><a style="font-size: 11px; color: #ed2a45;" href="/admin/?section=manual">{_t("admin.manual")}</a></td>
			<td align="right" style="padding-right: 10px;"><a style="font-size: 11px; color: #ed2a45;" href="/?logout">{_t("btn.logout")}</a></td>
		</tr>
		</table>
		</div>
		</td>
            
	</tr>
	<tr bgcolor="#333746" style="border-bottom:3px solid #d7d7d7;border-top:3px solid #313131;">
		<td><a href="/admin/"><img src="{$content_url}/images/sitograph/sitograph-logo-white-{if $lang == "ru" || $lang == "ua"}ru{else}en{/if}.png" style="border: none;height:80px;" /></a></td>
    	<td>
    		<table cellpadding="0" cellspacing="0">
    		<tr>
    			<td><a href="{$home_url}"><img src="{$theme_cms_favicon}"/></a></td>
    			<td style="padding-left: 10px;"><a style="font-size: 18px; color: #FFFFFF;" href="{$home_url}">{$host}</a></td>
    		</tr>
    		</table>        
        </td>
		<td>
    		<table cellpadding="0" cellspacing="0" width="120">
    		<tr>
    			<td><a href="{$home_url}"><img src="{$content_url}/images/sitograph/av_pic.gif"/></a></td>
    			<td style="padding-left: 10px;"><a class="admin_mode_link" href="{$home_url}">{_t("admin.view_website")}</a></td>
    		</tr>
    		</table>        
        
        </td>
	</tr>
    
	{if count($languages) > 1}
	<tr valign="top" style="position:absolute;right:0;">
		<td colspan="3" height="22">
		
		<table align="right" cellpadding="0" cellspacing="0" width="280">
		<tr>
			<td class="input_search_bg">
			
			<table align="right" cellpadding="0" cellspacing="0">
			<tr>
				<td>
<ul class="lang">
{foreach from=$languages item=langID}
{if $lang  == $langID}
	<li><span class="active">{$langID}</span></li>
{else}
	<li><a href="/admin/?lang={$langID}">{$langID}</a></li>
{/if}
{/foreach}
</ul>
				</td>
			</tr>
			</table>
			
			</td>
		</tr>
		</table>
		
		</td>
	</tr>
	{/if}
	
	<tr>
		<td colspan="2" height="75" class="header_bg">
		
		<div style="padding-left: 50px; font-family: Arial; font-size: 36px;">
		<div class="navi_title">{$admin_page_title}</div>
		</div>
		
		</td>
		<td style="padding-right: 5px; padding-top: 25px;">
		
		<form action="{$lang_url}/admin/?section=module_search&search" method="POST">
		<table align="right" cellpadding="0" cellspacing="0">
		<tr>
			<td><input class="input_search" type="text" name="keyword" value="" placeholder="{_t("form.search_placeholder")}"></td>
			<td><input type="image" src="{$content_url}/images/sitograph/btn_search.gif" name="search"/></td>
		</tr>
		</table>
		</form>
		
		</td>
	</tr>    

	</table>
	
	</td>
</tr>
<tr>
	<td>
	
	<table cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr valign="top">
		<td width="24" style="background: url(/content/images/sitograph/menu_left_bg.gif) repeat-y;"><img src="/content/images/sitograph/menu_left_img_top_2.gif"></td>
		<td width="220">
		
		<table cellpadding="0" cellspacing="0" width="220" height="100%">
		<tr valign="top">
			<td bgcolor="#E8E8E8" style="border-left: 1px solid #D2D2D2; border-right: 1px solid #E1E1E1; border-top: 1px solid #E1E1E1;">
            
            

<div id="menu_left">

{foreach from=$admin_menu key=menu_id item=item} 
{if $item.access === "superadmin" && $user.access === "superadmin" || $item.access === "admin" && $user.access === "admin" || $item.access === "admin" && $user.access === "superadmin"}
{if $item.submenu}
{if $admin_menu_active == $menu_id}
<div class="mod_box_active">
{else}
<div class="mod_box">
{/if}
<a href="#" onclick="return false;"><p class="">{$item.name}</p></a>
{foreach from=$item.submenu key=submenu_id item=subitem}
{if $subitem.access === "superadmin" && $user.access === "superadmin" || $subitem.access === "admin" && $user.access === "admin" || $subitem.access === "admin" && $user.access === "superadmin"}
{if $admin_submenu_active == $submenu_id} 
<div class="active">
{else}
<div class="">
{/if}
<a href="{$lang_url}{$subitem.url}">
<p {if $subitem.access === "superadmin"}class="admin_crown"{/if}>{$subitem.name}</p>
{if $admin_submenu_active == $submenu_id} 
<img id="menu_active_arrow" src="/content/images/sitograph/menu_h37px.gif">
{/if}
</a>
</div>
{/if}
{/foreach}

</div>
{else}
{if $item.url}
	{if $admin_menu_active == $menu_id}
		<div class="active">
			<a href="{$lang_url}{$item.url}">
				<p {if $item.access === "superadmin"}class="admin_crown"{/if}>{$item.name}</p></a>
			</a>
			<img id="menu_active_arrow" src="/content/images/sitograph/menu_h37px.gif" style="left: 218px;">
		</div>
	{else}
		<div class="">
		<a href="{$lang_url}{$item.url}">
			<p {if $item.access === "superadmin"}class="admin_crown"{/if}>{$item.name}</p></a>
		</a>
		</div>
	{/if}
{/if}
{/if}
{/if}
{/foreach}

        
	</td>
</tr>
</table>

</td>
<td width="15" style="padding-top: 10px;"></td>
<td width="auto" style="padding:15px;">

{if $message_error}
<div class="alert alert-danger">
{$message_error}
</div>
{/if}

{if $message_success}
<div class="alert alert-success">
{$message_success}
</div>
{/if}


{if $admin_page_template}
{assign var="filename" value="`$themePath`/sitograph/section/`$admin_page_template`"}
{include file="$filename"}
{/if}


</td>
	</tr>
	<tr>
		<td bgcolor="#f9f9f9" height="63" colspan="2" class="footer_bg"></td>
		<td bgcolor="#fff" height="63" colspan="2"></td>
	</tr>
	</tr>
	<tr>
		<td bgcolor="#333746" height="81"></td>
		<td bgcolor="#333746" valign="top" colspan="3">
			<div>
			<a href="http://sitograph.com/" target="_blank"><img src="{$content_url}/images/sitograph/sitograph-logo-white-{if $lang == "ru" || $lang == "ua"}ru{else}en{/if}.png" style="height:80px;"/></a>
			</div>
		</td>
	</tr>
	</table>
	
	</td>
</tr>
</table>
{$htmlFooter}

</body>
</html>