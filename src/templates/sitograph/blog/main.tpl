{if $blog_article_details}
    
	{include file="$themePath/blog/details.tpl"}
	 
{else}

   {include file="$themePath/blog/list.tpl"}
   
{/if} 