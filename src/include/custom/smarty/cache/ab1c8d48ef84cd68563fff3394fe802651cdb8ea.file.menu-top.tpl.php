<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:24
         compiled from "/Users/max/sitograph/src/templates/default/widget/menu-top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:532695593590b5edcab4620-98298559%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab1c8d48ef84cd68563fff3394fe802651cdb8ea' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/menu-top.tpl',
      1 => 1492202018,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '532695593590b5edcab4620-98298559',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menu' => 0,
    'home_url' => 0,
    'theme_logo' => 0,
    'host' => 0,
    'items' => 0,
    'page' => 0,
    'lang_url' => 0,
    'submenu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edcac5ad7_64998963',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edcac5ad7_64998963')) {function content_590b5edcac5ad7_64998963($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars["items"] = new Smarty_variable($_smarty_tpl->tpl_vars['menu']->value['top'], null, 0);?>


<div class="col-sm-3 logo-block">
	<a href="<?php echo $_smarty_tpl->tpl_vars['home_url']->value;?>
">
<?php if ($_smarty_tpl->tpl_vars['theme_logo']->value) {?>
	<img src="<?php echo $_smarty_tpl->tpl_vars['theme_logo']->value;?>
"/>
<?php } else { ?>
	<h1><?php echo $_smarty_tpl->tpl_vars['host']->value;?>
</h1>
<?php }?>
	</a>
</div>



	<div class="col-sm-8">
    <!-- Меню navbar -->
		<nav class="navbar navbar-default">
		  <!-- Бренд и переключатель, который вызывает меню на мобильных устройствах -->
		  <div class="navbar-header">
			<!-- Кнопка с полосочками, которая открывает меню на мобильных устройствах -->
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
			  <span class="sr-only">Toggle navigation</span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			</button>
			
		  </div>
		  <!-- Содержимое меню (коллекция навигационных ссылок, формы и др.) -->
		  <div class="collapse navbar-collapse" id="main-menu" >
			  <!-- Список ссылок, расположенных слева -->
			<ul class="nav navbar-nav">
			  <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['index'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['index']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['name'] = 'index';
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['items']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total']);
?>
                <?php if (!$_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['sub']) {?>
                <?php if ($_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['url']==$_smarty_tpl->tpl_vars['page']->value['url']) {?>
                    <li class="active"><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['name'];?>
</a></li>
                <?php } else { ?>
                    <li><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['name'];?>
</a></li>
                <?php }?>
                <?php } else { ?>
                <li class="dropdown">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['url'];?>
" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['name'];?>
<span class="caret"></span></a> 
                    <ul class="dropdown-menu" role="menu">
                    <?php  $_smarty_tpl->tpl_vars['submenu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['submenu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['submenu']->key => $_smarty_tpl->tpl_vars['submenu']->value) {
$_smarty_tpl->tpl_vars['submenu']->_loop = true;
?>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['submenu']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['submenu']->value['name'];?>
</a></li>
                    <?php } ?>
                    </ul>
                </li>
                <?php }?>
              <?php endfor; endif; ?> 
			</ul>
		  </div>
		</nav>
	</div>
			


<?php }} ?>
