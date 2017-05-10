<?php /* Smarty version Smarty-3.1.16, created on 2017-05-04 20:03:24
         compiled from "/Users/max/sitograph/src/templates/default/widget/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1940513114590b5edcb01118-65135792%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ffc53088a33d205b3e663d12103d34d6e714357' => 
    array (
      0 => '/Users/max/sitograph/src/templates/default/widget/footer.tpl',
      1 => 1493648164,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1940513114590b5edcb01118-65135792',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'theme_copyright_text' => 0,
    'htmlFooter' => 0,
    'admin_menu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_590b5edcb05713_68372917',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590b5edcb05713_68372917')) {function content_590b5edcb05713_68372917($_smarty_tpl) {?><div class="container footer">
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
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['themePath']->value)."/widget/menu-bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
    
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
</html><?php }} ?>
