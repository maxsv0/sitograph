<h3>Website Content</h3>

{$website_content_manager}


<fieldset class="legend">
    <legend class="legend">Upload files</legend>
    
    
    
<form class="form-inline">
  <div class="form-group">
    <label class="sr-only" for="exampleInputEmail3">Select file</label>
    <input type="file" class="form-control" id="exampleInputEmail3">
  </div>
  
  <button type="submit" class="btn btn-warning">Upload</button>
</form>
    
</fieldset>


{if $service_folder_link}
<a class="pull-right btn btn-primary" target="_blank" href="{$service_folder_link}">Open in Google Drive</a>
{/if}

{if $service_folder_manager}
<h3>Service Folder</h3>
{$service_folder_manager}
{/if}
