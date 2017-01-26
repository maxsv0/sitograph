
{if $gallery_album_details}

   {include file="$themePath/gallery/details.tpl"} 
     
{else}

   {include file="$themePath/gallery/list.tpl"}
   
{/if}