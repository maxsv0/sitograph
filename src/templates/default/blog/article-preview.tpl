<div class="articles-block" data-id="{$article.id}">

<div class="article-title-block">
<h2><a href="{$blog.baseUrl}{$article.url}/">{$article.title}</a></h2>
</div>

<div class="article-info-block">
	<div class="row">
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
</div>

{if $article.pic_preview}
<div class="article-media-block">
<a href="{$blog.baseUrl}{$article.url}/" title="{$article.title}">
<img src="{$article.pic_preview}" alt="{$article.title}" class="thumbnail img-responsive">
</a>
</div>
{/if}


{if $article.description}
	<p>{$article.description}</p>
{/if}

</div>