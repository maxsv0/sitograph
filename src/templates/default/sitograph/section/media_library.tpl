<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  
  
{foreach from=$admin_media_list key=mediaID item=mediaInfo}
<li role="presentation" class="{if $admin_media_active == $mediaID}active{/if}"><a href="#{$mediaID}" aria-controls="{$mediaInfo.name}" role="tab" data-toggle="tab">{$mediaInfo.name}</a></li>
{/foreach}
<li role="presentation" class="{if $admin_media_active == "upload"}active{/if}"><a href="#upload" aria-controls="upload" class="text-danger" role="tab" data-toggle="tab">Upload File</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
  

  
{foreach from=$admin_media_list key=mediaID item=mediaInfo} 
<div role="tabpanel" class="tab-pane {if $admin_media_active == $mediaID}active{/if}" id="{$mediaID}">
<p>
{_t("form.server_path")}: <b>{$mediaInfo.url}</b>
</p>

<table class='table table-hover'>
<tr>
<th class='col-sm-4'>{_t("admin.filename")}</th>
<th class='col-sm-2'>{_t("admin.filetype")}</th>
<th class='col-sm-3'>{_t("admin.filepreview")}</th>
<th class='col-sm-2'>{_t("admin.fileaccess")}</th>
<th class='col-sm-1'>{_t("actions")}</th>
</tr>

{foreach from=$mediaInfo.list_files key=filePath item=fileInfo} 
<tr>


<td>
<p>{$fileInfo.name}
<a href='{$fileInfo.url}' target='_blank'><span class='glyphicon glyphicon-new-window'></span></a>
</p>
</td>
<td>
{$fileInfo.type}
</td>

<td>
{if $fileInfo.type == "directory"}
	<a href="{$lang_url}/admin/?section=media_library&media={$mediaID}&mediapath={$fileInfo.url}" class="btn btn-info">open folder</a>
{elseif ($fileInfo.type == "image/png" || $fileInfo.type == "image/gif" || $fileInfo.type == "image/jpeg")}
	<img src="{$fileInfo.urlabs}" class="img-responsive" border="1">
{else}
	<a href="{$fileInfo.urlabs}" class="btn btn-primary" target="_blank">open file <span class='glyphicon glyphicon-new-window'></span></a>

{/if}
</td>
<td class="text-center">
{if $fileInfo.write}
	<span class="text-success">write</span>
{else}
	<span class="text-danger">readonly</span>
{/if}
</td>
<td>
	<a href="{$lang_url}/admin/?section={$admin_section}&media={$mediaID}&delete={$fileInfo.url}" title="{$t['btn.delete']}" class="btn btn-danger" onclick="if (!confirm('{$t['btn.remove_confirm']}')) return false;"><span class="glyphicon glyphicon-remove"></span></a>
</td>

</tr>
	
{/foreach}
</table>
    
{include "$themePath/sitograph/media/pic-upload.tpl" upload_path=$mediaInfo.url}

</div>
{/foreach}


<div role="tabpanel" class="tab-pane {if $admin_media_active == "upload"}active{/if}" id="upload">

{include "$themePath/sitograph/media/pic-upload.tpl" upload_path="/content"}
{include "$themePath/sitograph/media/file-upload.tpl" upload_path="/content"}

</div>



  </div>

</div>




{if $service_folder_link}
<a class="pull-right btn btn-primary" target="_blank" href="{$service_folder_link}">Open in Google Drive</a>
{/if}

{if $service_folder_manager}
<h3>Service Folder</h3>
{$service_folder_manager}
{/if}
