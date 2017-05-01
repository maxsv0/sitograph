{foreach from=$blog_articles key=article_id item=article} 

{include "$themePath/blog/article-list.tpl"}

{foreachelse}

<div class="alert alert-info">{_t('blog.search_no_result')}</div>

{/foreach} 
        
{include file="$themePath/widget/pagination.tpl" pagination=$blog_pages}
