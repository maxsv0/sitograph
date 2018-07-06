<div class="thumbnail galleryAlbum" data-id="{$album.id}">


<a href="{$lang_url}{$gallery.baseUrl}{$album.url}/" class="thumbnail-hover">
<img src="{$album.pic_preview}" alt="">
<span class="thumbnail-overlay">
<span class="thumbnail-text">
{$album.title}
</span>
</span>
</a>

<div class="caption">
	<p>
	{_t("gallery.posted_by")} {$album.author}, at {$album.date}
	</p>
	
	<p class="text-muted">
	{$album.photos|count} {_t("gallery.photos")},
	{$album.views} {_t("gallery.views")},
	{$album.shares} {_t("gallery.shares")},
	{$album.comments} {_t("gallery.comments")}
	</p>
	<br />
	<p><a href="{$lang_url}{$gallery.baseUrl}{$album.url}/" class="btn btn-primary" role="button">{_t("gallery.album_details")}</a></p>
</div>


</div> <!-- galleryAlbum -->
