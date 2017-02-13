{assign var="items" value=$menu['top']}

<div class="top-menu">
	<div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-8 col-sm-offset-4 col-xs-4 col-xs-offset-8">
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
                    {if !$smarty.section.index.last}<li class="line hidden-xs"></li>{/if}
                {else}
                    <li><a href="{$lang_url}{$items[index].url}">{$items[index].name}</a></li>
                    {if !$smarty.section.index.last}<li class="line hidden-xs"></li>{/if}
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
			  <!-- Список ссылок, расположенный справа 
			<ul class="nav navbar-nav navbar-right">
		  	  <li class="line hidden-xs"></li>	
			  <li><a href="#">Войти</a></li>
			</ul>-->
		  </div>
		</nav>
	</div>
			
</div>


