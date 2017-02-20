{assign var="items" value=$menu['user']}

<div class="pull-right">

{if $user.id}


<div class="dropdown">
  <p class="dropdown-toggle" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Hello, {$user.email}
    <span class="caret"></span>
  </p>
  <ul class="dropdown-menu" aria-labelledby="dropdownUser">
  
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


{if $user_auth_url}
<p>
	<a href="{$user_auth_url}">Login</a>
</p>
{/if}



</div>

{/if}