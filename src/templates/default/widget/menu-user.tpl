<div class="text-right">

{if $user.id}


<div class="dropdown">
  <p class="dropdown-toggle" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Hello, 
    <b>{$user.email}</b>&nbsp;<span class="caret"></span>
  </p>
  <ul class="dropdown-menu" aria-labelledby="dropdownUser">
  
{assign var="items" value=$menu['user']}

  
{section name=index loop=$items} 

{if $items[index].url == $page.url}
    <li class="active"><a href="{$lang_url}{$items[index].url}">{$items[index].name}</a></li>
{else}
    <li><a href="{$lang_url}{$items[index].url}">{$items[index].name}</a></li>
{/if}

{/section}

  </ul>
</div>

</div>

{else}


{assign var="items" value=$menu['nouser']}

<ul class="list-unstyled">
{section name=index loop=$items} 

{if $items[index].url == $page.url}
    <li class="active"><a href="{$lang_url}{$items[index].url}">{$items[index].name}</a></li>
{else}
    <li><a href="{$lang_url}{$items[index].url}">{$items[index].name}</a></li>
{/if}

{/section}
</ul>


</div>

{/if}