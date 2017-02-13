<div class="articles-block">

{if $article.sections}
<div class="articles_category">
{foreach from=$article.sections item=category name=loop} 
<a href="{$lang_url}/blog/?{$blog.categoryUrlParam}={$category.url}">{$category.title}</a>
{if !$smarty.foreach.loop.last} / {/if}
{/foreach}
</div>
{/if}


<a href="{$lang_url}/blog/{$article.url}/" class="title_link"><h4>{$article.title}</h4></a>

<div class="row">
	<p class="col-sm-6 text-muted small">
	<a href="{$lang_url}/blog/?{$blog.authorUrlParam}={$article.author}">{$article.author}</a> 
	posted on {$article.date}
	</p>
	
	<p class="col-sm-6 text-right small">
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
	</p>
</div>

{if $article.pic_preview}

<a href="{$lang_url}/blog/{$article.url}/">
<img src="{$article.pic_preview}" alt="">
</a>

{/if}

<div class="caption">
	
	
	
	{if $article.description}
	<p>{$article.description}</p>
	{/if}
	
	<p class="text-right small"><a href="{$lang_url}/blog/{$article.url}/" class="bg_red">{_t("blog.continue_reading")}</a></p>
</div>



</div> <!-- thumbnail -->	