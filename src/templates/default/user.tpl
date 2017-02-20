{include file="$themePath/widget/header.tpl"}



 <div class="container">
  	<div class="row content-block">


    {include file="$themePath/widget/menu-top.tpl"}

    <div class="row sep_line"></div>
    {include file="$themePath/widget/navigation.tpl"}
    	
    
    {if $page.name}
    <div class="col-lg-12 title_block"><h1>{$page.name}</h1></div>
    {/if}
    
    <div class="col-lg-8 col-md-7 col-sm-12">
    	{$document.text}
        {if $user.id}
        	{include file="$themePath/user/homepage.tpl"}
        {else}
        	{include file="$themePath/user/login.tpl"}
        {/if} 
    </div>
    <div class="col-lg-4 col-md-5 hidden-sm">
		{include file="$themePath/widget/sideblock.tpl"}
    </div>
	</div>
  </div>
  


{include file="$themePath/widget/footer.tpl"}