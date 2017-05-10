<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:34
  from "/Users/max/sitograph/src/templates/default/widget/navigation.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfe3c7785_87396469',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '15bbce90c4b2ac0652c57010d4627887cddc5769' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/navigation.tpl',
      1 => 1492201544,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfe3c7785_87396469 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['navigation']->value) {?>
<div class="container navigation">
    <ul class="bread_block block-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
    <?php
$__section_index_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index'] : false;
$__section_index_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['navigation']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_index_0_total = $__section_index_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_index'] = new Smarty_Variable(array());
if ($__section_index_0_total != 0) {
for ($__section_index_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] = 0; $__section_index_0_iteration <= $__section_index_0_total; $__section_index_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']++){
$_smarty_tpl->tpl_vars['__smarty_section_index']->value['last'] = ($__section_index_0_iteration == $__section_index_0_total);
?>
        <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['last'] : null)) {?>
        <li class="current-crumbs"><span><?php echo $_smarty_tpl->tpl_vars['navigation']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['name'];?>
</span></li>
        <?php } else { ?>
        <li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $_smarty_tpl->tpl_vars['lang_url']->value;
echo $_smarty_tpl->tpl_vars['navigation']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['navigation']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_index']->value['index'] : null)]['name'];?>
</a></li> 
         <li>&nbsp;>&nbsp;</li>
        <?php }?>
    <?php
}
}
if ($__section_index_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_index'] = $__section_index_0_saved;
}
?>   
	</ul> 
</div>
<?php }
}
}
