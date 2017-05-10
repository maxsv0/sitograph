<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 22:33:40
         compiled from "/Users/max/sitograph/src/templates/default/sitograph/section/structure.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1200062916590b8214c18aa1-90408381%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ef20e1133f1470f7017df58c1b935f68170c10cc' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/sitograph/section/structure.tpl',
      1 => 1490098877,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1200062916590b8214c18aa1-90408381',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'admin_edit_structure' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b8214c572e5_10351559',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b8214c572e5_10351559')) {function content_590b8214c572e5_10351559($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['admin_edit_structure']->value) {?>


    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/structure/edit.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>




<?php } else { ?>


	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/sitograph/structure/list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>



<?php }?>

<?php }} ?>
