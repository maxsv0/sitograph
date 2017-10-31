{if $blog_articles_topviews}
<h3>{_t("blog.label_popular_posts")}</h3>
{/if}

{foreach from=$blog_articles_topviews key=article_id item=article} 

<div class="media">
{if $article.pic_preview}
  <div class="media-left">
    <a href="{$lang_url}{$blog.baseUrl}{$article.url}/">
      <img class="media-object" src="{$article.pic_preview}" alt="{$article.title}" width="64">
    </a>
  </div>
{/if}
  <div class="media-body">
    <h4 style="margin-top:0;"><a href="{$lang_url}{$blog.baseUrl}{$article.url}/">{$article.title}</a></h4>
    <p class="text-muted">
      <small class="text-muted pull-right"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
          <a href="{$lang_url}{$blog.baseUrl}{$article.url}/#comments" class="text-muted">{$article.comments} {_t("blog.comments")}</a>
      </small>
      <small class="text-muted">{$article.date}</small><br>
    </p>
  </div>
</div>

{/foreach}

<p>&nbsp;</p>

<p class="text-center">
<div style="width:300px; height:600px; background: #c0c0c0;"></div>
<small class="text-muted">advertisment</small>
</p>

<br />

<div class="well">
  <form role="form" action="{$blog.baseUrl}">
    <div class="form-group">
      <label for="inputSearch" class="control-label">{_t("blog.label_search")}</label>
      <input type="text" id="inputSearch" name="{$blog.searchUrlParam}" class="form-control"/>
    </div>
    <input type="submit" class="btn btn-primary" value="{_t("blog.btn_search")}"/>
  </form>
</div>

