<!DOCTYPE html>

<head>
<title>Панель управления</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>


{$htmlHead}
<link rel="stylesheet" type="text/css" href="{$content_url}/css/admin-mcg.css" />
<script src="{$content_url}/js/tinymce/tinymce.min.js"></script>

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
		<td width="340">
		<div style="padding-bottom: 4px; font-size: 11px; color: #D9D9D9;">Вы вошли как {$user.email}</div>
		</td>
		<td width="293">
		<div style="padding-bottom: 4px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td>&nbsp;</td>
			<td align="right"><a style="font-size: 11px; color: #ec1d3d;" href="/admin/?section=manual">Инструкция</a></td>
			<td align="right" style="padding-right: 10px;"><a style="font-size: 11px; color: #ec1d3d;" href="/?logout">Выйти</a></td>
		</tr>
		</table>
		</div>
		</td>
            
	</tr>
	<tr>
		<td colspan="3" bgcolor="#313131" height="3"></td>
	</tr>
	<tr bgcolor="#3D3D3D">
		<td><a href="/admin/"><img class="block" src="{$content_url}/images/adminmcg/logo.gif" style="border: none;" /></a></td>
    	<td>
    		<table cellpadding="0" cellspacing="0">
    		<tr>
    			<td><img src="{$content_url}/images/adminmcg/{$admin_cms_icon}"/></td>
    			<td style="padding-left: 10px;"><span style="font-size: 18px; color: #FFFFFF;" >{$host}</span></td>
    		</tr>
    		</table>        
        </td>
		<td>
    		<table cellpadding="0" cellspacing="0">
    		<tr>
    			<td><img src="{$content_url}/images/adminmcg/av_pic.gif"/></td>
    			<td style="padding-left: 10px;"><a class="admin_mode_link" href="{$home_url}">Административный<br>просмотр сайта</a></td>
    		</tr>
    		</table>        
        
        </td>
	</tr>
    
	{if count($languages) > 1}
	<tr valign="top" style="background: url({$content_url}/images/adminmcg/heder_bg.gif) repeat-x;">
		<td colspan="3" height="25">
		
		<table align="right" cellpadding="0" cellspacing="0" width="280">
		<tr>
			<td style="background: url({$content_url}/images/adminmcg/lang_bg.gif) left top no-repeat; padding-right: 5px;">
			
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
	
	<tr style="background: url({$content_url}/images/adminmcg/heder_bg.gif) 0px -25px repeat-x;">
		<td colspan="2" height="75">
		
		<div style="padding-left: 50px; font-family: Arial; font-size: 36px;">
		<div class="navi_title">{$admin_menu_item.title}</div>
		</div>
		
		</td>
		<td style="padding-right: 5px;">
		
		<form action="{$lang_url}/admin/?section=module_search&menu_block=module_search&search" method="POST">
		<table align="right" cellpadding="0" cellspacing="0">
		<tr>
			<td><input class="input_search" type="text" name="keyword" value="Найти" onblur="if(this.value=='') this.value=Найти', this.style.color='#000000';" onfocus="if(this.value=='Найти') this.value='', this.style.color='#000000';"></td>
			<td><input type="image" src="{$content_url}/images/adminmcg/btn_search.gif" name="search"/></td>
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
		<td width="24" style="background: url(/content/images/adminmcg/menu_left_bg.gif) repeat-y;"><img src="/content/images/adminmcg/menu_left_img_top_2.gif"></td>
		<td width="236">
		
		<table cellpadding="0" cellspacing="0" width="236" height="100%">
		<tr valign="top">
			<td bgcolor="#E8E8E8" style="border-left: 1px solid #D2D2D2; border-right: 1px solid #E1E1E1;">
            
            

<div id="menu_left">

{foreach from=$admin_menu key=menu_id item=item} 
{if $item.access === "superadmin" && $user.access === "superadmin" || $item.access === "admin" && $user.access === "admin" || $item.access === "admin" && $user.access === "superadmin"}
{if $item.submenu}
{if $admin_info.id == $menu_id}
<div class="mod_box_active">
{else}
<div class="mod_box">
{/if}
<a href="#" onclick="return false;"><p class="">{$item.name}</p></a>
{foreach from=$item.submenu key=submenu_id item=subitem}
{if $admin_info.table == $submenu_id} 
<div class="active">
{else}
<div class="">
{/if}
<a href="{$lang_url}{$subitem.url}">
<p class="">{$subitem.name}</p>
{if $admin_info.table == $submenu_id} 
<img id="menu_active_arrow" src="/content/images/adminmcg/menu_h33px.gif" style="left: 234px;">
{/if}
</a>
</div>
{/foreach}

</div>
{else}
{if $item.url}
		{if $admin_info.id == $menu_id}
		<div class="active">
			<a href="{$lang_url}{$item.url}">
		{if $item.access === "superadmin"}
			<p class="admin_crown" style="background-position: 100% 11px;">{$item.name}</p></a>
		{else}
			<p>{$item.name}</p>
		{/if}
			</a>
			<img id="menu_active_arrow" src="/content/images/adminmcg/menu_h37px.gif" style="left: 234px;">
		</div>
		{else}
		<div class="">
		<a href="{$lang_url}{$item.url}">
		{if $item.access === "superadmin"}
			<p class="admin_crown" style="background-position: 100% 11px;">{$item.name}</p></a>
		{else}
			<p>{$item.name}</p>
		{/if}
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
<td width="30" style="padding-top: 10px;"></td>
<td>

<div style="padding:20px 20px 20px 10px;">

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


{if $admin_info.file}
{assign var="filename" value="`$themePath`/admin-mcg/`$admin_info.file`"}
{include file="$filename"}
{/if}

</div>		



</td>
	</tr>
	<tr>
		<td height="63"><img src="/content/images/adminmcg/menu_left_img_bottom_1.gif"/></td>
		<td bgcolor="#E8E8E8"><div style="border-left: 1px solid #D2D2D2; border-right: 1px solid #E1E1E1; padding-left: 25px;"><a href="http://mcg.net.ua/" target="_blank"><img src="/content/images/adminmcg/logo_mcg_part_1.gif"/></a></div></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td height="81"><img src="/content/images/adminmcg/menu_left_img_bottom_2.gif"/></td>
		<td bgcolor="#333333" valign="top"><div style="padding-left: 26px;"><a href="http://mcg.net.ua/" target="_blank"><img src="/content/images/adminmcg/logo_mcg_part_2.gif"/></a></div></td>
		<td bgcolor="#333333"></td>
		<td bgcolor="#333333"></td>
	</tr>
	</table>
	
	</td>
</tr>
<tr>
	<td bgcolor="#EDEDED" height="50"></td>
</tr>
</table>
{$htmlFooter}

</body>
</html>