{if $article.sections}
<div class="category-block">
{foreach from=$article.sections item=category name=loop} 
<h4><a href="{$lang_url}{$blog.baseUrl}?{$blog.categoryUrlParam}={$category.url}">{$category.title}</a></h4>
{if !$smarty.foreach.loop.last} / {/if}
{/foreach}
</div>
{/if}

<div class="articles-block" data-id="{$article.id}">

<h2><a href="{$lang_url}{$blog.baseUrl}{$article.url}/">{$article.title}</a></h2>

<div class="row article-info-block">
	<div class="col-sm-6 text-muted small">
	<a href="{$lang_url}{$blog.baseUrl}?{$blog.authorUrlParam}={$article.email}">{$article.email}</a>
	posted on {$article.date}
	</div>
	
	<div class="col-sm-6 text-right small">
	{$article.shares} Shares 
	&nbsp;&nbsp;&nbsp;
	<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
{if $article.views < 4000}
	{$article.views}
{else}
	{math equation="x / 1000" x=$article.views format="%.2f"}K
{/if}
	Views
	&nbsp;&nbsp;&nbsp;
	<span class="glyphicon glyphicon-comment" aria-hidden="true"></span> {$article.comments}
	</div>
</div>


{if $article.pic_preview}
<div class="article-media-block">
<a href="{$lang_url}{$blog.baseUrl}{$article.url}/">
<img src="{$article.pic_preview}" alt="" class="thumbnail img-responsive"/>
</a>
</div>
{/if}

<div class="article-description-block">
{if $article.description}
	{$article.description}
{/if}
</div>

<div class="article-more-block">
<a href="{$lang_url}{$blog.baseUrl}{$article.url}/" class="btn btn-primary">{_t("blog.continue_reading")}</a>
</div>



</div> 