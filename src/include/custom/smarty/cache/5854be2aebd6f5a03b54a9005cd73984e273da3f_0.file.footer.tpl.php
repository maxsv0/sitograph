<?php
/* Smarty version 3.1.32-dev-1, created on 2017-05-10 22:37:31
  from "/Users/max/sitograph/src/templates/default/widget/footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32-dev-1',
  'unifunc' => 'content_59136bfb7df316_02587007',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5854be2aebd6f5a03b54a9005cd73984e273da3f' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/footer.tpl',
      1 => 1493648164,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59136bfb7df316_02587007 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="container footer">
 	<div class="row">
 		<div class="col-lg-6 col-md-8 col-sm-8 col-xs-8">
			<h4>Sitograph Content Management System</h4>
			<div class="row">
				<div class="col-sm-3">E-mail</div>
				<div class="col-sm-9">
					<p>info@sitograph.com</p>
				</div>
				<div class="col-sm-3">Git Repository</div>
				<div class="col-sm-9">
					<p>
					<a href="https://github.com/maxsv0/sitograph" target="_blank">github.com/maxsv0/sitograph</a>  <small>CMS</small><br>
					<a href="https://github.com/maxsv0/msv" target="_blank">github.com/maxsv0/msv</a> <small>PHP Framework</small>
					</p>
				</div>
				
				<div class="col-sm-3">Report a problem</div>
				<div class="col-sm-9">
						<p>info@sitograph.com or <a href="/contacts/">feedback form</a></p>
				</div>
			</div>	
 		</div>
        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-4">
			<div class="bottom_menu">
                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
    
             </div>
		</div> 	
 	</div>
</div>   

<div class="container footer-copyright">
<div class="row">
	<p class="col-sm-12"><?php echo $_smarty_tpl->tpl_vars['theme_copyright_text']->value;?>
</p>
</div>
</div>


<?php echo $_smarty_tpl->tpl_vars['htmlFooter']->value;?>

<?php echo $_smarty_tpl->tpl_vars['admin_menu']->value;?>


</body>
</html><?php }
}
