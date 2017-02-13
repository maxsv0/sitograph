{if $navigation}
<div class="row navigation">
    <ul class="bread_block block-crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
    {section name=index loop=$navigation}
        {if $smarty.section.index.last}
        <li class="current-crumbs"><span>{$navigation[index].name}</span></li>
        {else}
        <li typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="{$lang_url}{$navigation[index].url}">{$navigation[index].name}</a></li> 
         <li>&nbsp;>&nbsp;</li>
        {/if}
    {/section}   
	</ul> 
</div>

{/if}