<fieldset class="legend">
    <legend class="legend">{_t("title.upload_files")} <b>{$upload_path}</b></legend>
    
   
    
<form class="form-inline" action="/api/uploadpic/" target="_blank" name="uploadForm" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label class="sr-only" for="iuploadFile">{_t("form.select_file")}</label>
    <input type="file" name="uploadFile" class="form-control" id="iuploadFile">
    <input type="hidden" name="uploadFilePath" value="{$upload_path}">
  </div>
  
  <button type="submit" class="btn btn-warning">{_t("btn.upload_file")}</button>
  
  <span style="margin-left:10px;">{_t("form.server_path")}: <a href="{$upload_path}" target="_blank">{$upload_path}</a></span>
</form>
    
</fieldset>