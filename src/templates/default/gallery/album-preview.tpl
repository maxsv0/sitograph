<div class="container">

<h3><a href="{$gallery.baseUrl}{$album.url}/">{$album.title}</a></h3>

<div class="row">	
<div class="col-sm-3">Author: <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {$album.author}</div>
<div class="col-sm-4">Published: {$album.date}</div>
<div class="col-sm-5">
{$album.photos|count} photos, 
{$album.views} views, 
{$album.shares} shares, 
{$album.comments} comments
</div>
</div>

{if $album.description}
<p>{$album.description}</p>
{/if}

{section name=index loop=$album.photos}
{if $smarty.section.index.index < 4}
<div class="col-sm-3">
<a rel="fancybox" href="{$album.photos[index].pic}">
<img  src="{$album.photos[index].pic_preview}" alt=""></a>
</div>
{else}
<div class="hide">
<a rel="fancybox" href="{$album.photos[index].pic}">
<img class="thumbnail" src="{$album.photos[index].pic_preview}" alt=""></a>
</div>
{/if} 
{/section} 

</div>