{if $article.sections}
<div class="category-block">
{foreach from=$article.sections item=category name=loop} 
<h4><a href="{$lang_url}{$blog.baseUrl}?{$blog.categoryUrlParam}={$category.url}">{$category.title}</a></h4>
{if !$smarty.foreach.loop.last} / {/if}
{/foreach}
</div>
{/if}

<div class="articles-block" data-id="{$article.id}">

<h2><a href="{$lang_url}{$blog.baseUrl}{$article.url}/">{$article.title_highlight}</a></h2>

<div class="row article-info-block">
{if $article.link}
	<div class="col-xs-12">
		Link: <a href="{$article.link}" target="_blank">{$article.link} <span class="glyphicon glyphicon-new-window"></span></a>
	</div>
{/if}
	<div class="col-sm-6 text-muted">
	<a href="{$lang_url}{$blog.baseUrl}?{$blog.authorUrlParam}={$article.email}">{$article.email}</a>
    {_t("blog.posted_on")} {$article.date}
	</div>
	
	<div class="col-sm-6 text-right">
	{$article.shares} {_t("blog.shares")}
	&nbsp;&nbsp;&nbsp;
	<span class="glyphicon glyphicon-eye-open" aria-hidden="true" title="{_t("blog.views")}"></span>
{if $article.views < 4000}
	{$article.views}
{else}
	{math equation="x / 1000" x=$article.views format="%.2f"}K
{/if}
	{_t("blog.views")}
	&nbsp;&nbsp;&nbsp;
	<span class="glyphicon glyphicon-comment" aria-hidden="true" title="{_t("blog.comments")}"></span> {$article.comments}
	</div>
</div>


{if $article.pic_preview}
<div class="article-media-block">
<a href="{$lang_url}{$blog.baseUrl}{$article.url}/">
<img src="{$article.pic_preview}" alt="{$article.title}" class="img-responsive"/>
{if $article.description}
	<span class="article-media-description">{$article.description_highlight}</span>
{else}
	<span class="article-media-description">{$article.title}</span>
{/if}
</a>
</div>
{/if}

<div class="article-more-block">
<a href="{$lang_url}{$blog.baseUrl}{$article.url}/" class="btn btn-primary">{_t("blog.continue_reading")}</a>
</div>



</div> 