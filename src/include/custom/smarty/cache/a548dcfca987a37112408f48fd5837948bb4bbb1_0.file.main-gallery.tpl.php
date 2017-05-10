<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:34
  from "/Users/max/sitograph/src/templates/default/main-gallery.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfe36cb38_05202147',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a548dcfca987a37112408f48fd5837948bb4bbb1' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/main-gallery.tpl',
      1 => 1493645509,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfe36cb38_05202147 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>


<div class="container top-menu">
	<div class="row">
		<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

	</div>
</div>

<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
	

<div class="container">
  	<div class="row content-block">
    <?php if ($_smarty_tpl->tpl_vars['gallery_album_details']->value['title']) {?>
    <div class="col-xs-12 album-title-block"><h1><?php echo $_smarty_tpl->tpl_vars['gallery_album_details']->value['title'];?>
</h1></div>
    <?php } elseif ($_smarty_tpl->tpl_vars['page']->value['name']) {?>
    <div class="col-xs-12 album-title-block"><h1><?php echo $_smarty_tpl->tpl_vars['page']->value['name'];?>
</h1></div>
    <?php }?>
    
    <div class="col-xs-12">
    	<?php if ($_smarty_tpl->tpl_vars['document']->value['text']) {
echo $_smarty_tpl->tpl_vars['document']->value['text'];?>
<br /><?php }?>
        <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/gallery/main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
 
    </div>
	</div>
</div>


<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
