<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:34
  from "/Users/max/sitograph/src/templates/default/widget/pagination.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfe4371c8_42643979',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a2326faf09b2def26e41ee97775135d2b42e5824' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/pagination.tpl',
      1 => 1484738064,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfe4371c8_42643979 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['pagination']->value) {?>

<div class="clearfix">&nbsp;</div>


<nav class="text-center">
  <ul class="pagination">
    
<?php if ($_smarty_tpl->tpl_vars['pagination']->value['prev']) {?>
<li><a href="<?php echo $_smarty_tpl->tpl_vars['pagination']->value['prev']['url'];
echo $_smarty_tpl->tpl_vars['urlsuffix']->value;?>
" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
<?php } else { ?>
<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
<?php }?>
    

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['pagination']->value['pages'], 'page', false, 'album_id');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['album_id']->value => $_smarty_tpl->tpl_vars['page']->value) {
if ($_smarty_tpl->tpl_vars['pagination']->value['current']['page'] === $_smarty_tpl->tpl_vars['page']->value['page']) {?>
<li class="active"><a href="<?php echo $_smarty_tpl->tpl_vars['page']->value['url'];
echo $_smarty_tpl->tpl_vars['urlsuffix']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value['name'];?>
</a></li>
<?php } else { ?>
<li><a href="<?php echo $_smarty_tpl->tpl_vars['page']->value['url'];
echo $_smarty_tpl->tpl_vars['urlsuffix']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value['name'];?>
</a></li>
<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
 

<?php if ($_smarty_tpl->tpl_vars['pagination']->value['next']) {?>
<li><a href="<?php echo $_smarty_tpl->tpl_vars['pagination']->value['next']['url'];
echo $_smarty_tpl->tpl_vars['urlsuffix']->value;?>
" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
<?php } else { ?>
<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
<?php }?>

  </ul>
</nav>
<?php }
}
}
