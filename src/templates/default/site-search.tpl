{include file="$themePath/widget/header.tpl"}

<div class="container top-menu">
    <div class="row">
        {include file="$themePath/widget/menu-top.tpl"}
    </div>
</div>

{include file="$themePath/widget/navigation.tpl"}

<div class="container">
    <div class="row content-block">

        {if $document.name}
            <div class="col-lg-12"><h1>{$document.name}</h1></div>
        {/if}

        <div class="col-lg-8 col-md-7 col-sm-12">
            {$document.text}

            <h4>{_t("blog.label_search")}</h4>
            <form class="row" action="{$lang_url}/search/?search" method="post">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">
                    <input type="text" id="inputSearch" name="keyword" value="{$search_str}" placeholder="{_t("search.btn_search")}" class="form-control"/>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <input type="submit" class="btn btn-primary" value="{_t("search.btn_search")}"/>
                </div>
            </form>
            <br>
            {if $search_result}
                <p>{_t("search.label_search_count")}&nbsp;{$search_count}</p>
                {foreach from=$search_result key=index item=items}
                    <div class="search-result">
                        <a class="bg_red" href="{$items.url}"><b>{$items.title}</b></a>
                        <p>{$items.text}</p>
                    </div>
                {/foreach}
            {else}
                <div class="alert alert-danger">{_t("search.label_search_err")|replace:'search_str':$search_str}</div>
            {/if}
            {if $set_more}
                <div class="btn_more" data-nextpage="1" data-search="{$search_str}" onclick="Get_More_Search(this)">{$t['search.more_search']}</div>
            {/if}
        </div>
        <div class="col-lg-4 col-md-5 hidden-sm">
            {include file="$themePath/widget/sideblock.tpl"}
        </div>
    </div>
</div>


{include file="$themePath/widget/footer.tpl"}