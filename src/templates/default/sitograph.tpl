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
			<td height="25" width="300">
				<div style="padding-bottom: 4px; padding-left: 10px; font-size: 10px; color: #4F4F4F;">{$admin_title_page}</div>
			</td>
			<td align="center">
				<div style="padding-bottom: 4px;">
					<a style="font-size: 11px; color: #ed2a45;" href="/admin/?section=manual">{_t("admin.manual")}</a>
				</div>
			</td>
			<td width="400">
				<div style="padding-bottom: 4px;">
					<table cellpadding="0" cellspacing="0" width="100%" class="small">
						<tr>
							<td>&nbsp;</td>
							<td align="right"><span style="color:#fff;">{_t("admin.logged_as")} {$user.email}</span>
								<span class="label label-success">{$user.access}</span></td>
							<td align="right" style="padding-right: 10px;"><a style="font-size: 11px; color: #ed2a45;" href="/?logout">{_t("btn.logout")}</a></td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr bgcolor="#333746" style="border-bottom:3px solid #d7d7d7;border-top:3px solid #313131;">
			<td><a href="/admin/"><img src="{$contentUrl}/images/sitograph/sitograph-logo-white-{if $lang == "ru" || $lang == "ua"}ru{else}en{/if}.png" style="border: none;height:80px;" /></a></td>
			<td align="center">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<td><a href="{$home_url}"><img src="{$theme_cms_favicon}"/></a></td>
						<td style="padding-left: 10px;"><a style="font-size: 18px; color: #FFFFFF;" href="{$home_url}">{$host}</a></td>
					</tr>
				</table>
			</td>
			<td align="right" style="padding-right:20px;">
				<table cellpadding="0" cellspacing="0">
					<tr>
{if $config_cms.favorites}
					{foreach from=$config_cms.favorites key=$favID item=favItem}
						<td width="150" align="center" class="btn_fav">
							<a href="{$favItem.url}">{$favItem.text}</a>
						</td>
					{/foreach}
{/if}
						<td width="150" align="center" class="btn_fav">
							<a href="{$home_url}">{_t("admin.view_website")}</a>
						</td>
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
			<div class="navi_title">
                {$admin_page_title}
                {if $cms_favorite_added}
					<a href="{$cms_favorite_url}&admin_favorites={$cms_favorite_id}&admin_favorites_remove"><span class="glyphicon glyphicon-star"></span></a>

					<a href="#" data-toggle="modal" data-target="#favoriteModal" style="font-size:14px;">
						<span class="glyphicon glyphicon-edit"></span> Edit
					</a>
                {else}

					<a href="#" data-toggle="modal" data-target="#favoriteModal">
						<span class="glyphicon glyphicon-star-empty"></span>
					</a>

                {/if}
			</div>
		</div>
		
		</td>
		<td style="padding-right: 5px; padding-top: 25px;">
		
		<form action="{$lang_url}/admin/?section=module_search&search" method="POST">
		<table align="right" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top"><input class="input_search" type="text" name="keyword" value="" placeholder="{_t("form.search_placeholder")}"></td>
			<td><input type="image" src="{$contentUrl}/images/sitograph/btn_search.gif" name="search"/></td>
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
		<td width="24" style="background: url({$contentUrl}/images/sitograph/menu_left_bg.gif) repeat-y;">&nbsp;</td>
		<td width="220" bgcolor="#E8E8E8">
		
		<table cellpadding="0" cellspacing="0" width="220" height="100%">
		<tr valign="top">
			<td bgcolor="#E8E8E8" style="border-left: 1px solid #D2D2D2; border-right: 1px solid #E1E1E1; border-top: 1px solid #E1E1E1;">
            
            

<div id="menu_left">

{foreach from=$admin_menu key=menu_id item=item} 
{if $item.access === "dev" && $user.access === "dev" || $item.access === "admin" && $user.access === "admin" || $item.access === "admin" && $user.access === "dev"}
{if $item.submenu}
{if $admin_menu_active == $menu_id}
<div class="mod_box_active">
{else}
<div class="mod_box">
{/if}
<a href="#" onclick="return false;"><p class="">{$item.name}</p></a>
{foreach from=$item.submenu key=submenu_id item=subitem}
{if $subitem.access === "dev" && $user.access === "dev" || $subitem.access === "admin" && $user.access === "admin" || $subitem.access === "admin" && $user.access === "dev"}
{if $admin_submenu_active == $submenu_id} 
<div class="active">
{else}
<div class="">
{/if}
<a href="{$lang_url}{$subitem.url}">
<p {if $subitem.access === "dev"}class="admin_crown"{/if}>{$subitem.name}</p>
{if $admin_submenu_active == $submenu_id} 
<img id="menu_active_arrow" src="{$contentUrl}/images/sitograph/menu_h37px.gif">
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
				<p {if $item.access === "dev"}class="admin_crown"{/if}>{$item.name}</p></a>
			</a>
			<img id="menu_active_arrow" src="{$contentUrl}/images/sitograph/menu_h37px.gif" style="left: 218px;">
		</div>
	{else}
		<div class="">
		<a href="{$lang_url}{$item.url}">
			<p {if $item.access === "dev"}class="admin_crown"{/if}>{$item.name}</p></a>
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
			<img src="{$contentUrl}/images/sitograph/sitograph-logo-white-{if $lang == "ru" || $lang == "ua"}ru{else}en{/if}.png" style="height:80px;"/>

				<h4 style="display: inline-block;">{$admin_title}</h4>
			</div>
		</td>
	</tr>
	</table>
	
	</td>
</tr>
</table>


<div class="modal fade" id="favoriteModal" tabindex="-1" role="dialog" aria-labelledby="favoriteModalLabel" aria-hidden="true">
	<form action="{$cms_favorite_url}">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="favoriteModalLabel">Edit Favorite Link</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="recipient-text" class="col-form-label">Text:</label>
						<input type="text" class="form-control" name="admin_favorites_text" value="{$cms_favorite_text}">
					</div>
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Link URL:</label>
						<input type="text" class="form-control" name="admin_favorites_url" value="{$cms_favorite_url}">
					</div>
					<input type="hidden" name="admin_favorites" value="{$cms_favorite_id}">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</form>
</div>

{$htmlFooter}

</body>
</html>