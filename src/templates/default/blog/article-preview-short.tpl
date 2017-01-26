<div class="thumbnail" style="border:0;">

{if $article.sections}
<div style="color: #999;text-transform:uppercase;">
{foreach from=$article.sections item=category name=loop} 
<a  style="color: #999;" href="/blog/?{$blog.categoryUrlParam}={$category.url}">{$category.title}</a>
{if !$smarty.foreach.loop.last} / {/if}
{/foreach}
</div>
{/if}



{if $article.pic_preview}

<a href="/blog/{$article.url}/">
<img src="{$article.pic_preview}" alt="">
</a>

{elseif $article.description}
<div class="caption">
	<p>{$article.description}</p>
</div>
{/if}



<a href="/blog/{$article.url}/"><h4 style="margin-top:10px;margin-bottom:5px;font-size:22px;">{$article.title}</h4></a>


</div> <!-- thumbnail -->	