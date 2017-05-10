<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:27
         compiled from "/Users/max/sitograph/src/templates/default/widget/pagination.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1400211868590b5edf56f844-37575680%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eb0bc2783fe55b167e62bb545403d620d5ebdafb' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/pagination.tpl',
      1 => 1484738064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1400211868590b5edf56f844-37575680',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pagination' => 0,
    'urlsuffix' => 0,
    'page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edf5804b1_56667337',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edf5804b1_56667337')) {function content_590b5edf5804b1_56667337($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['pagination']->value) {?>

<div class="clearfix">&nbsp;</div>


<nav class="text-center">
  <ul class="pagination">
    
<?php if ($_smarty_tpl->tpl_vars['pagination']->value['prev']) {?>
<li><a href="<?php echo $_smarty_tpl->tpl_vars['pagination']->value['prev']['url'];?>
<?php echo $_smarty_tpl->tpl_vars['urlsuffix']->value;?>
" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
<?php } else { ?>
<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
<?php }?>
    

<?php  $_smarty_tpl->tpl_vars['page'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['page']->_loop = false;
 $_smarty_tpl->tpl_vars['album_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['pagination']->value['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['page']->key => $_smarty_tpl->tpl_vars['page']->value) {
$_smarty_tpl->tpl_vars['page']->_loop = true;
 $_smarty_tpl->tpl_vars['album_id']->value = $_smarty_tpl->tpl_vars['page']->key;
?>
<?php if ($_smarty_tpl->tpl_vars['pagination']->value['current']['page']===$_smarty_tpl->tpl_vars['page']->value['page']) {?>
<li class="active"><a href="<?php echo $_smarty_tpl->tpl_vars['page']->value['url'];?>
<?php echo $_smarty_tpl->tpl_vars['urlsuffix']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value['name'];?>
</a></li>
<?php } else { ?>
<li><a href="<?php echo $_smarty_tpl->tpl_vars['page']->value['url'];?>
<?php echo $_smarty_tpl->tpl_vars['urlsuffix']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['page']->value['name'];?>
</a></li>
<?php }?>
<?php } ?> 

<?php if ($_smarty_tpl->tpl_vars['pagination']->value['next']) {?>
<li><a href="<?php echo $_smarty_tpl->tpl_vars['pagination']->value['next']['url'];?>
<?php echo $_smarty_tpl->tpl_vars['urlsuffix']->value;?>
" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
<?php } else { ?>
<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
<?php }?>

  </ul>
</nav>
<?php }?><?php }} ?>
