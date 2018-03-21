{assign var="items" value=$menu['bottom']}

<ul class="list-unstyled">
{section name=index loop=$items} 

{if $items[index].url == $page.url}
    <li class="active"><a href="{$lang_url}{$items[index].url}">{$items[index].name}</a></li>
{else}
    <li><a href="{$lang_url}{$items[index].url}">{$items[index].name}</a></li>
{/if}

{/section}
</ul>
