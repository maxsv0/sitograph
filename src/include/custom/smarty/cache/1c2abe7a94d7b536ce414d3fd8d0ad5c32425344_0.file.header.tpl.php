<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:31
  from "/Users/max/sitograph/src/templates/default/widget/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfb715bb0_79479434',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1c2abe7a94d7b536ce414d3fd8d0ad5c32425344' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/header.tpl',
      1 => 1493651661,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfb715bb0_79479434 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
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
				
<?php if (count($_smarty_tpl->tpl_vars['languages']->value) > 1) {?>
<p class="top-lang">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'langID');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['langID']->value) {
?> 
<?php $_smarty_tpl->_assignInScope('link', $_smarty_tpl->tpl_vars['home']->value[$_smarty_tpl->tpl_vars['langID']->value]);
?>
<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
"> <?php echo $_smarty_tpl->tpl_vars['langID']->value;?>
</a>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 
</p>
<?php }?> 
	     	</div>
	     	
	        <div class="col-xs-8 login-block">
	     	<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-user.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	     	</div>
	     	
	     	
	        </div>
	        
        </div>
 	</div>
       
</div>
<?php }
}
