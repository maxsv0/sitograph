{include file="$themePath/widget/header.tpl"}


  <div class="container">
  	<div class="row content-block">


    {include file="$themePath/widget/menu-top.tpl"}

    <div class="row sep_line"></div>	
    
    {if $page.title}
    <div class="col-lg-12 title_block"><h1>{$page.title}</h1></div>
    {/if}
    
    <div class="col-lg-8 col-md-7 col-sm-12 search_list">
        <div class="row search-result">
    			<form action="{$lang_url}/search/?search" method="post">
                  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-7 no-left-padding">  
    				<input type="text" name="keyword" value="{$search_str}" placeholder="{_t("search.btn_search")}"/>
    			  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                	<input type="submit" class="send-btn" value="{_t("search.btn_search")}"/>
    			  </div>	
    			</form>
    				
    	</div>
        {if $search_result}
        	<p>{_t("search.label_search_count")}&nbsp;{$search_count}</p>
            {foreach from=$search_result key=index item=items}
            <div class="search-result">
            <a class="bg_red" href="{$items.url}"><b>{$items.title}</b></a>
            <p>{$items.text}</p>
            </div>
            {/foreach}
        
        {else}
        <p>{_t("search.label_search_err")|replace:'search_str':$search_str}</p>
       
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