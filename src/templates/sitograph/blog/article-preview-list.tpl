<div class="media">
{if $article.pic_preview}
    <div class="media-left">
        <a href="{$lang_url}{$blog.baseUrl}{$article.url}/">
            <img class="media-object" src="{$article.pic_preview}" alt="{$article.title}" width="120">
        </a>
    </div>
{/if}
    <div class="media-body article-title-block">
        <h4 class="media-heading"><a href="{$lang_url}{$blog.baseUrl}{$article.url}/">{$article.title}</a></h4>
        <p class="text-muted">
            <a href="{$lang_url}{$blog.baseUrl}?{$blog.authorUrlParam}={$article.email}">{$article.email}</a>
            {_t("blog.posted_on")} {$article.date}
        </p>
{if $article.link}
        <p><a href="{$article.link}" target="_blank">{$article.link} <span class="glyphicon glyphicon-new-window"></span></a></p>
{/if}
{if $article.description}
        <p>{$article.description}</p>
{/if}
    </div>
</div>