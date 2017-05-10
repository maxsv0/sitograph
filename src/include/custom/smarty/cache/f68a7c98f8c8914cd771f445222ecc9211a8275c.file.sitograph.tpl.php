<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:35
         compiled from "/Users/max/sitograph/src/templates/default/sitograph.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1301478397590b5ee7628030-69286163%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f68a7c98f8c8914cd771f445222ecc9211a8275c' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph.tpl',
      1 => 1493648623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1301478397590b5ee7628030-69286163',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'htmlHead' => 0,
    'admin_title' => 0,
    'user' => 0,
    'content_url' => 0,
    'lang' => 0,
    'theme_cms_favicon' => 0,
    'host' => 0,
    'home_url' => 0,
    'languages' => 0,
    'langID' => 0,
    'admin_page_title' => 0,
    'lang_url' => 0,
    'admin_menu' => 0,
    'item' => 0,
    'admin_menu_active' => 0,
    'menu_id' => 0,
    'subitem' => 0,
    'admin_submenu_active' => 0,
    'submenu_id' => 0,
    'message_error' => 0,
    'message_success' => 0,
    'admin_page_template' => 0,
    'themePath' => 0,
    'htmlFooter' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5ee767ed64_54886555',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5ee767ed64_54886555')) {function content_590b5ee767ed64_54886555($_smarty_tpl) {?><!DOCTYPE html>

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
/images/sitograph/sitograph-logo-white-<?php if ($_smarty_tpl->tpl_vars['lang']->value=="ru"||$_smarty_tpl->tpl_vars['lang']->value=="ua") {?>ru<?php } else { ?>en<?php }?>.png" style="border: none;height:80px;" /></a></td>
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
    
	<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
	<tr valign="top" style="position:absolute;right:0;">
		<td colspan="3" height="22">
		
		<table align="right" cellpadding="0" cellspacing="0" width="280">
		<tr>
			<td class="input_search_bg">
			
			<table align="right" cellpadding="0" cellspacing="0">
			<tr>
				<td>
<ul class="lang">
<?php  $_smarty_tpl->tpl_vars['langID'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['langID']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['langID']->key => $_smarty_tpl->tpl_vars['langID']->value) {
$_smarty_tpl->tpl_vars['langID']->_loop = true;
?>
<?php if ($_smarty_tpl->tpl_vars['lang']->value==$_smarty_tpl->tpl_vars['langID']->value) {?>
	<li><span class="active"><?php echo $_smarty_tpl->tpl_vars['langID']->value;?>
</span></li>
<?php } else { ?>
	<li><a href="/admin/?lang=<?php echo $_smarty_tpl->tpl_vars['langID']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['langID']->value;?>
</a></li>
<?php }?>
<?php } ?>
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

<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['menu_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['admin_menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['menu_id']->value = $_smarty_tpl->tpl_vars['item']->key;
?> 
<?php if ($_smarty_tpl->tpl_vars['item']->value['access']==="superadmin"&&$_smarty_tpl->tpl_vars['user']->value['access']==="superadmin"||$_smarty_tpl->tpl_vars['item']->value['access']==="admin"&&$_smarty_tpl->tpl_vars['user']->value['access']==="admin"||$_smarty_tpl->tpl_vars['item']->value['access']==="admin"&&$_smarty_tpl->tpl_vars['user']->value['access']==="superadmin") {?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['submenu']) {?>
<?php if ($_smarty_tpl->tpl_vars['admin_menu_active']->value==$_smarty_tpl->tpl_vars['menu_id']->value) {?>
<div class="mod_box_active">
<?php } else { ?>
<div class="mod_box">
<?php }?>
<a href="#" onclick="return false;"><p class=""><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</p></a>
<?php  $_smarty_tpl->tpl_vars['subitem'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['subitem']->_loop = false;
 $_smarty_tpl->tpl_vars['submenu_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['submenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['subitem']->key => $_smarty_tpl->tpl_vars['subitem']->value) {
$_smarty_tpl->tpl_vars['subitem']->_loop = true;
 $_smarty_tpl->tpl_vars['submenu_id']->value = $_smarty_tpl->tpl_vars['subitem']->key;
?>
<?php if ($_smarty_tpl->tpl_vars['subitem']->value['access']==="superadmin"&&$_smarty_tpl->tpl_vars['user']->value['access']==="superadmin"||$_smarty_tpl->tpl_vars['subitem']->value['access']==="admin"&&$_smarty_tpl->tpl_vars['user']->value['access']==="admin"||$_smarty_tpl->tpl_vars['subitem']->value['access']==="admin"&&$_smarty_tpl->tpl_vars['user']->value['access']==="superadmin") {?>
<?php if ($_smarty_tpl->tpl_vars['admin_submenu_active']->value==$_smarty_tpl->tpl_vars['submenu_id']->value) {?> 
<div class="active">
<?php } else { ?>
<div class="">
<?php }?>
<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['subitem']->value['url'];?>
">
<p <?php if ($_smarty_tpl->tpl_vars['subitem']->value['access']==="superadmin") {?>class="admin_crown"<?php }?>><?php echo $_smarty_tpl->tpl_vars['subitem']->value['name'];?>
</p>
<?php if ($_smarty_tpl->tpl_vars['admin_submenu_active']->value==$_smarty_tpl->tpl_vars['submenu_id']->value) {?> 
<img id="menu_active_arrow" src="/content/images/sitograph/menu_h37px.gif">
<?php }?>
</a>
</div>
<?php }?>
<?php } ?>

</div>
<?php } else { ?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['url']) {?>
	<?php if ($_smarty_tpl->tpl_vars['admin_menu_active']->value==$_smarty_tpl->tpl_vars['menu_id']->value) {?>
		<div class="active">
			<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
">
				<p <?php if ($_smarty_tpl->tpl_vars['item']->value['access']==="superadmin") {?>class="admin_crown"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</p></a>
			</a>
			<img id="menu_active_arrow" src="/content/images/sitograph/menu_h37px.gif" style="left: 218px;">
		</div>
	<?php } else { ?>
		<div class="">
		<a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
">
			<p <?php if ($_smarty_tpl->tpl_vars['item']->value['access']==="superadmin") {?>class="admin_crown"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</p></a>
		</a>
		</div>
	<?php }?>
<?php }?>
<?php }?>
<?php }?>
<?php } ?>

        
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


<?php if ($_smarty_tpl->tpl_vars['admin_page_template']->value) {?>
<?php $_smarty_tpl->tpl_vars["filename"] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/section/".((string)$_smarty_tpl->tpl_vars['admin_page_template']->value), null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['filename']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
/images/sitograph/sitograph-logo-white-<?php if ($_smarty_tpl->tpl_vars['lang']->value=="ru"||$_smarty_tpl->tpl_vars['lang']->value=="ua") {?>ru<?php } else { ?>en<?php }?>.png" style="height:80px;"/></a>
			</div>
		</td>
	</tr>
	</table>
	
	</td>
</tr>
</table>
<?php echo $_smarty_tpl->tpl_vars['htmlFooter']->value;?>


</body>
</html><?php }} ?>
