{if $blog_articles_search}
    <div class="well clearfix">
        <form role="form" action="{$blog.baseUrl}">
            <label for="inputSearch" class="control-label">{_t("blog.label_search")}</label>
            <div class="form-group">
                <div class="col-sm-8">
                    <input type="text" id="inputSearch" name="{$blog.searchUrlParam}" class="form-control" value="{$blog_articles_search_keyword}"/>
                </div>
                <div class="col-sm-4">
                    <input type="submit" class="btn btn-primary" value="{_t("blog.btn_search")}"/>
                </div>
           </div>
        </form>
    </div>
{/if}

{foreach from=$blog_articles key=article_id item=article}

{include "$themePath/blog/article-list.tpl"}

{foreachelse}

<div class="alert alert-info">{_t('blog.search_no_result')}</div>

{/foreach} 
        
{include file="$themePath/widget/pagination.tpl" pagination=$blog_pages}
