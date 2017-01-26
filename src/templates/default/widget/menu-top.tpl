{assign var="items" value=$menu['top']}


<!-- Static navbar -->
<nav class="navbar navbar-kica">
<div class="">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>
  <div id="navbar" class="navbar-collapse  navbar-default collapse">
    <ul class="nav navbar-nav">
    
{section name=index loop=$items}

{if !$items[index].sub}


{if $items[index].url == $page.url}
    <li class="active"><a href="{$lang_url}{$items[index].url}">{$items[index].name}</a></li>
{else}
    <li><a href="{$lang_url}{$items[index].url}">{$items[index].name}</a></li>
{/if}


{else}


<li class="dropdown">
<a href="{$lang_url}{$items[index].url}" class="dropdown-toggle" data-toggle="dropdown">{$items[index].name}<span class="caret"></span></a> 
     
<ul class="dropdown-menu" role="menu">
{foreach from=$items[index].sub item=submenu}
<li><a href="{$lang_url}{$submenu.url}">{$lang_url}{$submenu.name}</a></li>
{/foreach}
</ul>
</li>


{/if}

{/section} 
    
    </ul>
  
  </div><!--/.nav-collapse -->
    
</div><!--/.container-fluid -->
</nav>
