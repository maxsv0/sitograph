<div class="thumbnail galleryAlbum">


<a href="/gallery/{$album.url}/">
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
	
	<p><a href="/gallery/{$album.url}/" class="btn btn-primary" role="button">Album details</a></p>
</div>


</div> <!-- galleryAlbum -->
