<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:27
         compiled from "/Users/max/sitograph/src/templates/default/gallery/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:941347614590b5edfaf0cd6-87233990%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1459a547c66beec57c5736a77ae0acdb9b8c8512' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/gallery/main.tpl',
      1 => 1484738064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '941347614590b5edfaf0cd6-87233990',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gallery_album_details' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edfb07d86_25011463',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edfb07d86_25011463')) {function content_590b5edfb07d86_25011463($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['gallery_album_details']->value) {?>

   <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/gallery/details.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
     
<?php } else { ?>

   <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/gallery/list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

   
<?php }?><?php }} ?>
