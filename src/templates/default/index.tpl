{include file="$themePath/widget/header.tpl"}

<div class="container top-menu">
	<div class="row">
		{include file="$themePath/widget/menu-top.tpl"}
	</div>
</div>

<div class="container promo-block">
	{$document.text}
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
        {include file="$themePath/widget/feedback_sticked.tpl"}
	</div><!-- row -->
</div>

{include file="$themePath/widget/footer.tpl"}
