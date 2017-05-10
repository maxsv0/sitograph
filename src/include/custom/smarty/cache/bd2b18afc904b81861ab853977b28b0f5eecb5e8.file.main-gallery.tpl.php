<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:27
         compiled from "/Users/max/sitograph/src/templates/default/main-gallery.tpl" */ ?>
<?php /*%%SmartyHeaderCode:622193648590b5edfaa83f1-79101967%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bd2b18afc904b81861ab853977b28b0f5eecb5e8' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/main-gallery.tpl',
      1 => 1493645509,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '622193648590b5edfaa83f1-79101967',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gallery_album_details' => 0,
    'page' => 0,
    'document' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edfad21b3_32550252',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edfad21b3_32550252')) {function content_590b5edfad21b3_32550252($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div class="container top-menu">
	<div class="row">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
	

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
    	<?php if ($_smarty_tpl->tpl_vars['document']->value['text']) {?><?php echo $_smarty_tpl->tpl_vars['document']->value['text'];?>
<br /><?php }?>
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/gallery/main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
    </div>
	</div>
</div>


<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
