{assign var="items" value=$menu['top']}


<div class="col-sm-3 logo-block">
	<a href="{$home_url}">
{if $theme_logo}
	<img src="{$theme_logo}"/>
{else}
	<h1>{$host}</h1>
{/if}
	</a>
</div>



	<div class="col-sm-8">
    <!-- Меню navbar -->
		<nav class="navbar navbar-default">
		  <!-- Бренд и переключатель, который вызывает меню на мобильных устройствах -->
		  <div class="navbar-header">
			<!-- Кнопка с полосочками, которая открывает меню на мобильных устройствах -->
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
			  <span class="sr-only">Toggle navigation</span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			</button>
			
		  </div>
		  <!-- Содержимое меню (коллекция навигационных ссылок, формы и др.) -->
		  <div class="collapse navbar-collapse" id="main-menu" >
			  <!-- Список ссылок, расположенных слева -->
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
		  </div>
		</nav>
	</div>
			


