{assign var="items" value=$menu['top']}


<div class="blog-masthead">
  <div class="container">
    <nav class="blog-nav">
    
{section name=index loop=$items} 

{if $items[index].url == $page.url}
	<a class="blog-nav-item active" href="{$lang_url}{$items[index].url}">{$items[index].name}</a>
{else}
	<a class="blog-nav-item" href="{$lang_url}{$items[index].url}">{$items[index].name}</a>
{/if}

{/section}
   
    </nav>
  </div>
</div>

