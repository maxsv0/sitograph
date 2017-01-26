
<div class="well well-lg"">
<form class="form-horizontal" action="/blog/">
  <div class="form-group text-left">
  	<label for="inputSearch" class="control-label">Search:</label>
  	<input type="text" id="inputSearch" name="{$blog.searchUrlParam}" class="">
  	<input type="submit" class="btn btn-sm btn-primary" value="Search">
  </div>
</form>
</div>



<h3>Popular posts</h3>

{foreach from=$blog_articles_topviews key=article_id item=article} 

<div class="media">
  <div class="media-left">
    <a href="/blog/{$article.url}/">
{if $article.pic_preview}
      <img class="media-object" src="{$article.pic_preview}" alt="{$article.title}" width="64">
{/if}
    </a>
  </div>
  <div class="media-body">
    <a href="/blog/{$article.url}/"><h4 class="media-heading">{$article.title}</h4></a>
  </div>
</div>

{/foreach} 