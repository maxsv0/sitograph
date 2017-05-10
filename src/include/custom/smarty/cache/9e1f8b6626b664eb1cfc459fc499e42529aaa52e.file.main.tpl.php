<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:27
         compiled from "/Users/max/sitograph/src/templates/default/blog/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1842254749590b5edf5399a4-22575300%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9e1f8b6626b664eb1cfc459fc499e42529aaa52e' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/blog/main.tpl',
      1 => 1484738064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1842254749590b5edf5399a4-22575300',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'blog_article_details' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edf53f5a7_26560869',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edf53f5a7_26560869')) {function content_590b5edf53f5a7_26560869($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['blog_article_details']->value) {?>
    
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	 
<?php } else { ?>

   <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/blog/list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

   
<?php }?> <?php }} ?>
