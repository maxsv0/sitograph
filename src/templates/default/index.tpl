{include file="$themePath/widget/header.tpl"}

<div class="container top-menu">
	<div class="row">
		{include file="$themePath/widget/menu-top.tpl"}
	</div>
</div>

<div class="container promo-block">
	{$document.text}
</div>

<div class="container promo-block" style="background:url(/content/images/sitograph/sitograph-promo-responsive.png);">
	<div class="row">
		<div class="col-lg-5 col-md-5 col-sm-6 col-lg-offset-7 col-md-offset-7">
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<h2>Flexible customization</h2>
			<p>&nbsp;</p>
			<div class="lead">Sitograph CMS is a modular system and can be adapted to match 100% of your needs.</div>
			<p class="lead"><a href="http://demo.sitograph.com/" class="btn btn-primary btn-lg" target="_blank"><span class="glyphicon glyphicon-circle-arrow-right"></span> Visit Demo Sitograph CMS</a>&nbsp;</p>
		</div>
	</div>
</div>

<div class="container content-block">
	<div class="row" style="margin:100px auto;">
		<div class="col-md-10 col-md-offset-1">
			<h2>Sitograph CMS Admin Homepage</h2>
			<a class="thumbnail" href="http://demo.sitograph.com/admin/" title="Demo Sitograph CMS">
				{*<img src="https://www.sitograph.com/content/articles/2018/04/screen-demo-sitograph-5acc681cce581.jpg" alt="Demo Sitograph CMS">*}
				<img src="https://www.sitograph.com/content/articles/2018/04/7-pic_preview-5acc683ce810c.jpg" alt="Demo Sitograph CMS">
			</a>
			<h3><a href="http://demo.sitograph.com/admin/">http://demo.sitograph.com/admin/</a></h3>
		</div>
	</div>
</div>

<div class="container promo-block">
	<div class="row">
		<div class="col-md-5">
			<h2  style="margin-left:70px;margin-top:50px;">Sitograph CMS features</h2>

			<ul class="lead" style="margin-left:70px; line-height: 2;">
				<li>Edit documents, photos, videos, etc.</li>
				<li>Adaptive web design</li>
				<li>Email Marketing</li>
				<li>Multi-language support</li>
				<li>Configurable JSON API</li>
				<li>User management and real-time analytics</li>
			</ul>
			<p>&nbsp;</p>
		</div>
		<div class="col-md-7">
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>
				<img src="" alt="Demo Sitograph CMS" class="img-responsive">
			</p>
		</div>
	</div>
</div>

<div class="container content-block">
	<div class="row">

	<div class="col-lg-8 col-md-7 col-sm-12">

{foreach from=$blog_articles_newest key=article_id item=article} 
{if $article@iteration <= 3}
{include "$themePath/blog/article-preview.tpl"}
{/if}
{/foreach}
	</div>
	
	<div class="col-lg-4 col-md-5 hidden-sm">
	{include file="$themePath/widget/sideblock.tpl"}
	</div>
	
	</div><!-- row -->

	<br>

	<div class="row">
{foreach from=$blog_articles_newest key=article_id item=article} 
{if $article@iteration > 3}
<div class="col-lg-3 col-md-4 col-sm-6">
{include "$themePath/blog/article-preview-short.tpl"}
</div>
{/if}
{/foreach}
	

	</div><!-- row -->
</div>

<div class="container feedback-block">
	<div class="row">
        {include file="$themePath/widget/feedback-sticked.tpl"}
	</div><!-- row -->
</div>

{include file="$themePath/widget/footer.tpl"}
