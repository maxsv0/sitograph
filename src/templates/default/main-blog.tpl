{include file="$themePath/widget/header.tpl"}

<div class="container top-menu">
	<div class="row">
		{include file="$themePath/widget/menu-top.tpl"}
	</div>
</div>

{include file="$themePath/widget/navigation.tpl"}

<div class="container">
  	<div class="row content-block">
    {if $blog_article_details.title}
    <div class="col-lg-12 article-title-block"><h1>{$blog_article_details.title}</h1></div>
    {elseif $document.name}
    <div class="col-lg-12 article-title-block"><h1>{$document.name}</h1></div>
    {/if}
    
    <div class="col-lg-8 col-md-7 col-sm-12">
    	{if $document}{$document.text}{/if}
        {include file="$themePath/blog/main.tpl"}
    </div>
    <div class="col-lg-4 col-md-5 hidden-sm">
		{include file="$themePath/widget/sideblock.tpl"}
    </div>
	</div>
</div>
  

{include file="$themePath/widget/footer.tpl"}