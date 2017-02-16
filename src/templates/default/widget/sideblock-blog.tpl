<div class="sideblock_search">
<form role="form" action="{$lang_url}/blog/">
			  <div class="form-group">
				<label for="inputSearch" class="control-label">{_t("blog.label_search")}</label>
				<input type="text" id="inputSearch" name="{$blog.searchUrlParam}" class=""/>
			  </div>
			  <input type="submit" class="send-btn" value="{_t("blog.btn_search")}"/>
</form>
</div>
<br />


<h3>{_t("blog.label_рopular_posts")}</h3>

{foreach from=$blog_articles_topviews key=article_id item=article} 

<div class="media">
  <div class="media-left">
    <a href="{$lang_url}/blog/{$article.url}/">
{if $article.pic_preview}
      <img class="media-object" src="{$article.pic_preview}" alt="{$article.title}" width="64">
{/if}
    </a>
  </div>
  <div class="media-left-title">
    <a href="{$lang_url}/blog/{$article.url}/">{$article.title}</a>
  </div>
</div>

{/foreach} 