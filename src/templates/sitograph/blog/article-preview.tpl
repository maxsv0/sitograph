<div class="articles-block" data-id="{$article.id}">

<div class="article-title-block">
<h2><a href="{$blog.baseUrl}{$article.url}/">{$article.title}</a></h2>
</div>

<div class="article-info-block">
	<div class="row">
{if $article.link}
	<div class="col-xs-12">
		Link: <a href="{$article.link}" target="_blank">{$article.link} <span class="glyphicon glyphicon-new-window"></span></a>
	</div>
{/if}
	<div class="col-sm-6 text-muted small">
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
</div>

{if $article.pic_preview}
<div class="article-media-block">
<a href="{$blog.baseUrl}{$article.url}/" title="{$article.title}">
<img src="{$article.pic_preview}" alt="{$article.title}" class="img-responsive">
{if $article.description}
	<span class="article-media-description">{$article.description}</span>
{else}
	<span class="article-media-description">{$article.title}</span>
{/if}
</a>
</div>
{/if}




</div>