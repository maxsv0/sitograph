<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:38:45
  from "/Users/max/sitograph/src/templates/default/sitograph.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136c45b84992_32162824',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b49e3f1dd37be8b61224c4baf92175f3a0f6e0b5' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph.tpl',
      1 => 1493648623,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136c45b84992_32162824 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>

<head>
<title>Панель управления</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>

<?php echo $_smarty_tpl->tpl_vars['htmlHead']->value;?>


</head>



<body bottommargin="0" leftmargin="0" marginheight="0" marginwidth="0" rightmargin="0" topmargin="0">


<table cellpadding="0" cellspacing="0" width="100%" height="100%">
<tr>
	<td height="1">
	
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr valign="bottom" bgcolor="#000000">
    
		<td height="25">
		<div style="padding-bottom: 4px; padding-left: 10px; font-size: 10px; color: #4F4F4F;"><?php echo $_smarty_tpl->tpl_vars['admin_title']->value;?>
</div>
		</td>
		<td width="340">
		<div style="padding-bottom: 4px; font-size: 11px; color: #D9D9D9;"><?php echo _t("admin.logged_as");?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
</div>
		</td>
		<td width="293">
		<div style="padding-bottom: 4px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td>&nbsp;</td>
			<td align="right"><a style="font-size: 11px; color: #ed2a45;" href="/admin/?section=manual"><?php echo _t("admin.manual");?>
</a></td>
			<td align="right" style="padding-right: 10px;"><a style="font-size: 11px; color: #ed2a45;" href="/?logout"><?php echo _t("btn.logout");?>
</a></td>
		</tr>
		</table>
		</div>
		</td>
            
	</tr>
	<tr bgcolor="#333746" style="border-bottom:3px solid #d7d7d7;border-top:3px solid #313131;">
		<td><a href="/admin/"><img src="<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/images/sitograph/sitograph-logo-white-<?php if ($_smarty_tpl->tpl_vars['lang']->value == "ru" || $_smarty_tpl->tpl_vars['lang']->value == "ua") {?>ru<?php } else { ?>en<?php }?>.png" style="border: none;height:80px;" /></a></td>
    	<td>
    		<table cellpadding="0" cellspacing="0">
    		<tr>
    			<td><img src="<?php echo $_smarty_tpl->tpl_vars['theme_cms_favicon']->value;?>
"/></td>
    			<td style="padding-left: 10px;"><span style="font-size: 18px; color: #FFFFFF;" ><?php echo $_smarty_tpl->tpl_vars['host']->value;?>
</span></td>
    		</tr>
    		</table>        
        </td>
		<td>
    		<table cellpadding="0" cellspacing="0" width="120">
    		<tr>
    			<td><img src="<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/images/sitograph/av_pic.gif"/></td>
    			<td style="padding-left: 10px;"><a class="admin_mode_link" href="<?php echo $_smarty_tpl->tpl_vars['home_url']->value;?>
"><?php echo _t("admin.view_website");?>
</a></td>
    		</tr>
    		</table>        
        
        </td>
	</tr>
    
	<?php if (count($_smarty_tpl->tpl_vars['languages']->value) > 1) {?>
	<tr valign="top" style="position:absolute;right:0;">
		<td colspan="3" height="22">
		
		<table align="right" cellpadding="0" cellspacing="0" width="280">
		<tr>
			<td class="input_search_bg">
			
			<table align="right" cellpadding="0" cellspacing="0">
			<tr>
				<td>
<ul class="lang">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'langID');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['langID']->value) {
if ($_smarty_tpl->tpl_vars['lang']->value == $_smarty_tpl->tpl_vars['langID']->value) {?>
	<li><span class="active"><?php echo $_smarty_tpl->tpl_vars['langID']->value;?>
</span></li>
<?php } else { ?>
	<li><a href="/admin/?lang=<?php echo $_smarty_tpl->tpl_vars['langID']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['langID']->value;?>
</a></li>
<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</ul>
				</td>
			</tr>
			</table>
			
			</td>
		</tr>
		</table>
		
		</td>
	</tr>
	<?php }?>
	
	<tr>
		<td colspan="2" height="75" class="header_bg">
		
		<div style="padding-left: 50px; font-family: Arial; font-size: 36px;">
		<div class="navi_title"><?php echo $_smarty_tpl->tpl_vars['admin_page_title']->value;?>
</div>
		</div>
		
		</td>
		<td style="padding-right: 5px; padding-top: 25px;">
		
		<form action="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/admin/?section=module_search&search" method="POST">
		<table align="right" cellpadding="0" cellspacing="0">
		<tr>
			<td><input class="input_search" type="text" name="keyword" value="" placeholder="<?php echo _t("form.search_placeholder");?>
"></td>
			<td><input type="image" src="<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/images/sitograph/btn_search.gif" name="search"/></td>
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

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['admin_menu']->value, 'item', false, 'menu_id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['menu_id']->value => $_smarty_tpl->tpl_vars['item']->value) {
?> 
<?php if ($_smarty_tpl->tpl_vars['item']->value['access'] === "superadmin" && $_smarty_tpl->tpl_vars['user']->value['access'] === "superadmin" || $_smarty_tpl->tpl_vars['item']->value['access'] === "admin" && $_smarty_tpl->tpl_vars['user']->value['access'] === "admin" || $_smarty_tpl->tpl_vars['item']->value['access'] === "admin" && $_smarty_tpl->tpl_vars['user']->value['access'] === "superadmin") {
if ($_smarty_tpl->tpl_vars['item']->value['submenu']) {
if ($_smarty_tpl->tpl_vars['admin_menu_active']->value == $_smarty_tpl->tpl_vars['menu_id']->value) {?>
<div class="mod_box_active">
<?php } else { ?>
<div class="mod_box">
<?php }?>
<a href="#" onclick="return false;"><p class=""><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</p></a>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['submenu'], 'subitem', false, 'submenu_id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['submenu_id']->value => $_smarty_tpl->tpl_vars['subitem']->value) {
if ($_smarty_tpl->tpl_vars['subitem']->value['access'] === "superadmin" && $_smarty_tpl->tpl_vars['user']->value['access'] === "superadmin" || $_smarty_tpl->tpl_vars['subitem']->value['access'] === "admin" && $_smarty_tpl->tpl_vars['user']->value['access'] === "admin" || $_smarty_tpl->tpl_vars['subitem']->value['access'] === "admin" && $_smarty_tpl->tpl_vars['user']->value['access'] === "superadmin") {
if ($_smarty_tpl->tpl_vars['admin_submenu_active']->value == $_smarty_tpl->tpl_vars['submenu_id']->value) {?> 
<div class="active">
<?php } else { ?>
<div class="">
<?php }?>
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;
echo $_smarty_tpl->tpl_vars['subitem']->value['url'];?>
">
<p <?php if ($_smarty_tpl->tpl_vars['subitem']->value['access'] === "superadmin") {?>class="admin_crown"<?php }?>><?php echo $_smarty_tpl->tpl_vars['subitem']->value['name'];?>
</p>
<?php if ($_smarty_tpl->tpl_vars['admin_submenu_active']->value == $_smarty_tpl->tpl_vars['submenu_id']->value) {?> 
<img id="menu_active_arrow" src="/content/images/sitograph/menu_h37px.gif">
<?php }?>
</a>
</div>
<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


</div>
<?php } else {
if ($_smarty_tpl->tpl_vars['item']->value['url']) {?>
	<?php if ($_smarty_tpl->tpl_vars['admin_menu_active']->value == $_smarty_tpl->tpl_vars['menu_id']->value) {?>
		<div class="active">
			<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;
echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
">
				<p <?php if ($_smarty_tpl->tpl_vars['item']->value['access'] === "superadmin") {?>class="admin_crown"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</p></a>
			</a>
			<img id="menu_active_arrow" src="/content/images/sitograph/menu_h37px.gif" style="left: 218px;">
		</div>
	<?php } else { ?>
		<div class="">
		<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;
echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
">
			<p <?php if ($_smarty_tpl->tpl_vars['item']->value['access'] === "superadmin") {?>class="admin_crown"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</p></a>
		</a>
		</div>
	<?php }
}
}
}
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


        
	</td>
</tr>
</table>

</td>
<td width="15" style="padding-top: 10px;"></td>
<td width="auto" style="padding:15px;">

<?php if ($_smarty_tpl->tpl_vars['message_error']->value) {?>
<div class="alert alert-danger">
<?php echo $_smarty_tpl->tpl_vars['message_error']->value;?>

</div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['message_success']->value) {?>
<div class="alert alert-success">
<?php echo $_smarty_tpl->tpl_vars['message_success']->value;?>

</div>
<?php }?>


<?php if ($_smarty_tpl->tpl_vars['admin_page_template']->value) {
$_smarty_tpl->_assignInScope('filename', ((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/section/".((string)$_smarty_tpl->tpl_vars['admin_page_template']->value));
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['filename']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }?>


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
			<a href="http://sitograph.com/" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/images/sitograph/sitograph-logo-white-<?php if ($_smarty_tpl->tpl_vars['lang']->value == "ru" || $_smarty_tpl->tpl_vars['lang']->value == "ua") {?>ru<?php } else { ?>en<?php }?>.png" style="height:80px;"/></a>
			</div>
		</td>
	</tr>
	</table>
	
	</td>
</tr>
</table>
<?php echo $_smarty_tpl->tpl_vars['htmlFooter']->value;?>


</body>
</html><?php }
}
