<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:24
         compiled from "/Users/max/sitograph/src/templates/default/widget/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1147735442590b5edca79a39-51167678%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee62582dae7eaaa7a9dd1dfecaf411c7f1ea64a7' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/header.tpl',
      1 => 1493651661,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1147735442590b5edca79a39-51167678',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page' => 0,
    'htmlHead' => 0,
    'theme_bg' => 0,
    'content_url' => 0,
    'lang_url' => 0,
    'search_str' => 0,
    'languages' => 0,
    'langID' => 0,
    'home' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edca920e5_14297654',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edca920e5_14297654')) {function content_590b5edca920e5_14297654($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title><?php echo $_smarty_tpl->tpl_vars['page']->value['title'];?>
</title>
	<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['page']->value['keywords'];?>
"/>
	<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['page']->value['description'];?>
"/>
	<?php echo $_smarty_tpl->tpl_vars['htmlHead']->value;?>

</head>
<body <?php if ($_smarty_tpl->tpl_vars['theme_bg']->value) {?>style="background: url(<?php echo $_smarty_tpl->tpl_vars['theme_bg']->value;?>
) #FFF;"<?php }?>>

<div class="container header">
    <div class="row">
		<div class="col-sm-4">
			<div class="phone-block">
 		       <table cellpadding="0" cellspacing="0" width="170" style="margin-bottom:15px">
				<tr>
					<td style="padding-right: 10px;"><img src="<?php echo $_smarty_tpl->tpl_vars['content_url']->value;?>
/images/pic_tel.gif" width="14" height="14" alt="Контактные телефоны"></td>
					<td style="font-size: 13px; white-space: nowrap; color: #FFF;">
					+380 (44) 536-00-66<br/>
					+380 (93) 898-33-70
					</td>
				</tr>
				</table>
            </div>  
		</div>
		<div class="col-sm-4">
			<div class="search-block">
				<form action="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
/search/?search" method="post">
					<input type="text" name="keyword" class="input-sm" value="<?php echo $_smarty_tpl->tpl_vars['search_str']->value;?>
" placeholder="<?php echo _t("form.search_lable");?>
"/>
					<button type="submit" value="search" class="btn btn-sm"><?php echo _t("btn.search");?>
</button>
				</form>
			</div>
		</div>
    	<div class="col-sm-4">
	        <div class="row">
	        <div class="col-xs-4 header-menu">
	     <p>
				
				<a href="/sitemap/" class="sitemap-ico"></a>
				<span class="top-delimiter"></span>
				<a href="/contacts/" class="mail-ico"></a>
				<span class="top-delimiter"></span>
		</p>
				
<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
<p class="top-lang">
<?php  $_smarty_tpl->tpl_vars['langID'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['langID']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['langID']->key => $_smarty_tpl->tpl_vars['langID']->value) {
$_smarty_tpl->tpl_vars['langID']->_loop = true;
?> 
<?php $_smarty_tpl->tpl_vars["link"] = new Smarty_variable($_smarty_tpl->tpl_vars['home']->value[$_smarty_tpl->tpl_vars['langID']->value], null, 0);?>
<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
"> <?php echo $_smarty_tpl->tpl_vars['langID']->value;?>
</a>
<?php } ?> 
</p>
<?php }?> 
	     	</div>
	     	
	        <div class="col-xs-8 login-block">
	     	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	     	</div>
	     	
	     	
	        </div>
	        
        </div>
 	</div>
       
</div>
<?php }} ?>
