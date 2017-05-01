
{if $article.pic_preview}
<div class="article-media-block">
<a href="/blog/{$article.url}/" title="{$article.title}">
<img src="{$article.pic_preview}" alt="{$article.title}" class="thumbnail img-responsive">
</a>
</div>
{elseif $article.description}
<div class="caption">
	<p>{$article.description}</p>
</div>
{/if}


<div class="article-title-block">
<h4><a href="/blog/{$article.url}/">{$article.title}</a></h4>
</div>
