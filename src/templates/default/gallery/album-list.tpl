<div class="thumbnail galleryAlbum" data-id="{$album.id}">


<a href="{$lang_url}{$gallery.baseUrl}{$album.url}/">
<img src="{$album.pic_preview}" alt="">
</a>

<div class="caption">
	<h4>{$album.title}</h4>
	<p>
	posted by {$album.author}, at {$album.date}
	</p>
	
	<p class="text-muted">
	{$album.photos|count} photos, 
	{$album.views} views, 
	{$album.shares} shares, 
	{$album.comments} comments
	</p>
	<br />
	<p><a href="{$lang_url}{$gallery.baseUrl}{$album.url}/" class="btn btn-primary" role="button">Album details</a></p>
</div>


</div> <!-- galleryAlbum -->
