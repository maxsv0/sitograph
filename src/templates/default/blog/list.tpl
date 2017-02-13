<div class="container">
<div class="row content-block">


    {include file="$themePath/widget/menu-top.tpl"}
    
    <div class="row sep_line"></div>	
    {include file="$themePath/widget/navigation.tpl"}
    
    
    {if $page.name}
    <div class="col-lg-12 title_block"><h1>{$page.name}</h1></div>
    {/if}
    
    <div class="col-lg-8 col-md-7 col-sm-12">
    	{$document.text}
        {foreach from=$blog_articles key=article_id item=article} 
        
        
        {include "$themePath/blog/article-list.tpl"}
        <div class="articles_sep_line"></div>
        
        {foreachelse}
        
        <div class="alert alert-info">No articles was found.</div>
        
        {/foreach} 
                
        {include file="$themePath/widget/pagination.tpl" pagination=$blog_pages}
        
    </div>
    <div class="col-lg-4 col-md-5 hidden-sm">
    	{include file="$themePath/widget/sideblock.tpl"}
    </div>
</div>
</div>


