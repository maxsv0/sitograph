<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:34
  from "/Users/max/sitograph/src/templates/default/gallery/list.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfe402284_06703574',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '259e5b479f9ca44404c609ec7c226e0e1f5d588c' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/gallery/list.tpl',
      1 => 1493645211,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfe402284_06703574 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['gallery_albums']->value, 'album', false, 'album_id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['album_id']->value => $_smarty_tpl->tpl_vars['album']->value) {
?> 

<div class="col-sm-4 rowItem">
<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/gallery/album-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

</div>


<?php
}
} else {
?>


<div class="alert alert-info"><?php echo _t('gallery.search_no_result');?>
</div>


<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 



<?php $_smarty_tpl->_assignInScope('pagination', $_smarty_tpl->tpl_vars['gallery_pages']->value);
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
