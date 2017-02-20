{include file="$themePath/widget/header.tpl"}


  <div class="container">
  	<div class="row content-block">


    {include file="$themePath/widget/menu-top.tpl"}

    <div class="row sep_line"></div>
    
    {include file="$themePath/widget/navigation.tpl"}	
    {if $gallery_album_details.title}
    <div class="col-lg-12 title_block"><h1>{$gallery_album_details.title}</h1></div>
    {elseif $page.name}
    <div class="col-lg-12 title_block"><h1>{$page.name}</h1></div>
    {/if}
    
    <div class="col-lg-8 col-md-7 col-sm-12">
    	{if $document.text}{$document.text}<br />{/if}
        {include file="$themePath/gallery/main.tpl"} 
    </div>
    <div class="col-lg-4 col-md-5 hidden-sm">
		{include file="$themePath/widget/sideblock.tpl"}
    </div>
	</div>
  </div>


{include file="$themePath/widget/footer.tpl"}
