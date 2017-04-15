
{if $blog_article_details.sections}
<div class="category-block">
{foreach from=$blog_article_details.sections item=category name=loop} 
<h4><a href="{$lang_url}/blog/?{$blog.categoryUrlParam}={$category.url}">{$category.title}</a></h4>
{if !$smarty.foreach.loop.last} / {/if}
{/foreach}
</div>
{/if}



<div class="article-info-block">
	<div class="row">
	<div class="col-sm-6 text-muted small">
		<a href="{$lang_url}/blog/?{$blog.authorUrlParam}={$blog_article_details.author}">{$blog_article_details.author}</a> 
		posted on {$blog_article_details.date}
		</div>
		
		
		<div class="col-sm-6 text-right small">
		{$blog_article_details.shares} Shares 
		&nbsp;&nbsp;&nbsp;
		<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
		
{if $blog_article_details.views < 4000}
	{$blog_article_details.views}
{else}
	{math equation="x / 1000" x=$blog_article_details.views format="%.2f"}K
{/if}		
		Views
		&nbsp;&nbsp;&nbsp;
		<span class="glyphicon glyphicon-comment" aria-hidden="true"></span> {$blog_article_details.comments}
	</div>
	</div>
</div>
		
	
	
{if $blog_article_details.pic_preview}
<div class="article-media-block">
<a href="{$blog_article_details.pic}" rel="fancybox"  title="{$blog_article_details.title}">
<img src="{$blog_article_details.pic_preview}" alt="{$blog_article_details.title}" class="thumbnail img-responsive">
</a>
</div>
{/if}
	

{if $blog_article_details.categories}
<div class="category2-block">
{foreach from=$blog_article_details.categories item=category} 
<a href="/blog/?{$blog.categoryUrlParam}={$category.url}" class="btn btn-default">{$category.title}</a>
{/foreach}
</div>
{/if}
	
	
{if $blog_article_details.album}
<div class="row" >
{foreach from=$blog_article_details.album.photos item=photo name=loop}
<div class="hide">
<a class="thumbnail" rel="fancybox" title="{$blog_article_details.title}" href="{$photo.pic}"><img src="{$photo.pic_preview}" alt=""></a>
</div>
{/foreach}
</div>
{/if}
	
	

	
	{if $blog_article_details.text}
		<p>{$blog_article_details.text}</p>
	{elseif $blog_article_details.description}
		<p>{$blog_article_details.description}</p>
	{/if}
	

<hr/>


{if $blog_articles_related}
<h3>{_t("blog.label_related_posts")}</h3>
<div class="row rowItems">
{foreach from=$blog_articles_related key=article_id item=article} 
{if $article@iteration > 6}{break}{/if}
<div class="col-sm-6 col-md-4 rowItem">
{if $article.pic_preview}
<p>
	<a href="{$lang_url}/blog/{$article.url}/"><img src="{$article.pic_preview}" alt="{$article.title}" class="img-responsive"></a>
</p>
{/if}
<p>  
    <a href="{$lang_url}/blog/{$article.url}/"><h4 class="media-heading">{$article.title}</h4></a>
</p>  
{if !$article.pic_preview}
<p>
	{$article.description}
</p>
{/if}
</div>
{/foreach} 
</div>
{/if}

<p class="clearfix"></p>

{if $blog_articles_newest}

<h3>{_t("blog.label_latest_posts")}</h3>
{foreach from=$blog_articles_newest key=article_id item=article} 
{if $article@iteration > 7}{break}{/if}
<div class="media">
  <div class="media-left">
    <a href="{$lang_url}/blog/{$article.url}/">
{if $article.pic_preview}
      <img class="media-object" src="{$article.pic_preview}" alt="{$article.title}" width="120">
{/if}
    </a>
  </div>
  <div class="media-body">
    <a href="{$lang_url}/blog/{$article.url}/"><h4 class="media-heading">{$article.title}</h4></a>
    
 	{if $article.description}
	<p>{$article.description}</p>
	{/if}
  </div>
</div>
{/foreach} 
{/if}


