<div class="container">
{include file="$themePath/widget/navigation.tpl"}
</div>	<!-- container navigation -->



{if $document}
<div class="container">
{$document.text}
</div>	<!-- container document -->
{/if}




<div class="container">
<div class="row">

<form class="form-horizontal col-sm-10 col-sm-offset-1">
  <div class="form-group text-left">
  	<label for="inputSearch" class="control-label">Search:</label>
  	<input type="text" id="inputSearch" name="{$gallery.searchUrlParam}" class="">
  	<input type="submit" class="btn btn-sm" value="Search">
  </div>
</form>

</div>	<!-- row -->
</div>	<!-- container -->





<div class="container">
<div class="row rowItems">

{foreach from=$gallery_albums key=album_id item=album} 

<div class="col-sm-4 rowItem">
{include "$themePath/gallery/album-list.tpl"}
</div>


{foreachelse}
<div class="col-sm-6 col-md-offset-2">
<div class="well">No photos was found.</div>
</div>
{/foreach} 



</div><!-- row -->
</div><!-- container -->

{assign var="pagination" value=$gallery_pages}
{include file="$themePath/widget/pagination.tpl"}



