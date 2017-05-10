<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:31
  from "/Users/max/sitograph/src/templates/default/widget/menu-top.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfb797212_49891748',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2c7c17ab21162a31f5cb3e91c54db37a990efa88' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/menu-top.tpl',
      1 => 1492202018,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfb797212_49891748 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('items', $_smarty_tpl->tpl_vars['menu']->value['top']);
?>


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
			  <?php
$__section_index_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index'] : false;
$__section_index_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['items']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_index_2_total = $__section_index_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_index'] = new Smarty_Variable(array());
if ($__section_index_2_total != 0) {
for ($__section_index_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] = 0; $__section_index_2_iteration <= $__section_index_2_total; $__section_index_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']++){
?>
                <?php if (!$_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['sub']) {?>
                <?php if ($_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['url'] == $_smarty_tpl->tpl_vars['page']->value['url']) {?>
                    <li class="active"><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;
echo $_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['name'];?>
</a></li>
                <?php } else { ?>
                    <li><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;
echo $_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['name'];?>
</a></li>
                <?php }?>
                <?php } else { ?>
                <li class="dropdown">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;
echo $_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['url'];?>
" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['name'];?>
<span class="caret"></span></a> 
                    <ul class="dropdown-menu" role="menu">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['items']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['sub'], 'submenu');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['submenu']->value) {
?>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;
echo $_smarty_tpl->tpl_vars['submenu']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang_url']->value;
echo $_smarty_tpl->tpl_vars['submenu']->value['name'];?>
</a></li>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                    </ul>
                </li>
                <?php }?>
              <?php
}
}
if ($__section_index_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_index'] = $__section_index_2_saved;
}
?> 
			</ul>
		  </div>
		</nav>
	</div>
			


<?php }
}
