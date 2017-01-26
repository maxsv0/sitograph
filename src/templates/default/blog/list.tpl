<div class="container">
{include file="$themePath/widget/navigation.tpl"}


<div class="row">
<div class="col-md-8">


{if $document}
{$document.text}
{/if}









<div class="row rowItems">


{foreach from=$blog_articles key=article_id item=article} 

<div class="col-sm-12 rowItem">
{include "$themePath/blog/article-list.tpl"}
</div>

{foreachelse}
<div class="col-sm-6 col-md-offset-2">
<div class="alert alert-info">No articles was found.</div>
</div>
{/foreach} 


</div><!-- row -->




{include file="$themePath/widget/pagination.tpl" pagination=$blog_pages}



</div>

<div class="col-md-4">
	{include file="$themePath/widget/sideblock.tpl"}
</div>



</div><!-- row -->
</div><!-- container -->