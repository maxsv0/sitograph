{foreach from=$blog_articles key=article_id item=article} 

{include "$themePath/blog/article-list.tpl"}

{foreachelse}

<div class="alert alert-info">No articles was found.</div>

{/foreach} 
        
{include file="$themePath/widget/pagination.tpl" pagination=$blog_pages}
