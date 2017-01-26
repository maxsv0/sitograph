<div class="thumbnail" style="border:0;">

{if $article.sections}
<div style="color: #999;text-transform:uppercase;">
{foreach from=$article.sections item=category name=loop} 
<a  style="color: #999;" href="/blog/?{$blog.categoryUrlParam}={$category.url}">{$category.title}</a>
{if !$smarty.foreach.loop.last} / {/if}
{/foreach}
</div>
{/if}


<a href="/blog/{$article.url}/"><h4 style="margin-top:10px;margin-bottom:5px;font-size:22px;">{$article.title}</h4></a>

<div class="row">
	<p class="col-sm-6 text-muted small">
	<a href="/blog/?{$blog.authorUrlParam}={$article.author}">{$article.author}</a> 
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

<a href="/blog/{$article.url}/">
<img src="{$article.pic_preview}" alt="">
</a>

{/if}

<div class="caption">
	
	
	
	{if $article.description}
	<p>{$article.description}</p>
	{/if}
	
</div>



</div> <!-- thumbnail -->	