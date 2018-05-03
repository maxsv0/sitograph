<div>
 
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  
{foreach from=$admin_edit_tabs key=tabID item=tabInfo name=loop}
{if is_array($tabInfo.fields) && count($tabInfo.fields) > 0}
<li role="presentation"{if $smarty.foreach.loop.first} class="active"{/if}><a href="#{$tabID}" aria-controls="{$tabID}" role="tab" data-toggle="tab">{$tabInfo.title}</a></li>
{/if}
{/foreach}
  </ul>
  
<form action="{$lang_url}{$admin_url}" class="form-horizontal" method="POST" id="admin-edit" enctype="multipart/form-data">

  <!-- Tab panes -->
  <div class="tab-content">
  
  
{foreach from=$admin_edit_tabs key=tabID item=tabInfo name=loop}
{if is_array($tabInfo.fields) && count($tabInfo.fields) > 0}
<div role="tabpanel" class="tab-pane {if $smarty.foreach.loop.first}active{/if}" id="{$tabID}">

{foreach from=$tabInfo.fields item=itemField}
{include "$themePath/sitograph/field-form.tpl" form_id="form" item_type=$itemField.type item_id=$itemField.name item_name=$itemField.name value=$dataList[$itemField.name] title=$itemField.title readonly=$itemField.readonly}
{/foreach}

</div>
{/if}
{/foreach}
  
  </div>
 
<input type="hidden" value="{$admin_section}" id="section" name="section">
<input type="hidden" value="{$admin_table}" id="table" name="table">
<input type="hidden" value="{$dataList.id}" id="itemID" name="itemID">
<input type="hidden" value="{$admin_list_page}" id="p" name="p">
<input type="hidden" value="{$referer}" id="referer" name="referer">

<div class="alert hide">&nbsp;</div>

<div class="">
<div class="form-group-btn">
	<button type="submit" class="btn btn-danger btn-lg" name="cancel" id="cancel" type="button"><span class="glyphicon glyphicon-remove-circle">&nbsp;</span>{$t["btn.cancel"]}</button>
	<button class="btn btn-danger btn-lg" type="reset"><span class="glyphicon glyphicon-ban-circle">&nbsp;</span>{$t["btn.reset"]}</button>
	<button type="submit" name="save" id="btnSave" value="1" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-repeat">&nbsp;</span>{$t["btn.save"]}</button>
	<button type="submit" name="save_exit" value="1" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-ok">&nbsp;</span>{$t["btn.save_exit"]}</button>
</div>
</div>
</form>



</div>





<!-- Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{$t["title.upload_files"]}</h4>
        
        <div class="row text-muted">
        <p class="col-sm-4">{_t("title.upload_step1")}</p>
        <p class="col-sm-4">{_t("title.upload_step2")}</p>
        <p class="col-sm-4">{_t("title.upload_step3")}</p>
        </div>
      </div>
      <div class="modal-body">

<div id="uploadPreview" class="hide">
<img src="about:blank" class="">
</div>    
      
    <div id="uploadDiv">
	<form action="/api/uploadpic/" name="uploadForm" id="fUploadForm" method="post" enctype="multipart/form-data" target="uploadFrame">
	<input name="uploadFile" id="iUploadFile" type="file" class="form-control" style="height: 50px;"/>
	<input name="table" id="iUploadTable" type="hidden" value="{$admin_table}"/>
	<input name="field" id="iUploadField" type="hidden" value=""/>
	<input type="submit" name="submitBtn" id="btnSubmitUpload" value="{$t["btn.upload_file"]}" class="btn btn-warning btn-block"/>
	</form>	
	<iframe id="uploadFrame" name="uploadFrame" src="about:blank" style="width:0;height:0;border:0px solid #fff;" onload="if (typeof uploadFrameLoad === 'function') uploadFrameLoad(this);"></iframe>
	</div>
        
    <div id="uploadStatus" class="hide" style="margin-top:10px;">
    <div id="uploadAlert" class=""></div>
	</div>
      
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{$t["btn.close"]}</button>
        <button type="button" class="btn btn-primary" onclick="closeUploadModal();" id="btnUploadSave">{$t["btn.save"]}</button>
      </div>
    </div>
  </div>
</div>

<input id="uploadFilePath" type="hidden" value=""/>










<!-- Modal -->
<div class="modal fade" id="libraryModal" tabindex="-1" role="dialog" aria-labelledby="libraryModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{$t["admin.media_library"]} - {$t["module.$admin_section"]}</h4>
      </div>
      <div class="modal-body">
      
      
<div>
<img class="img-responsive cropper" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" id="picPreview">
</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{$t["btn.close"]}</button>
        <button type="button" class="btn btn-primary" onclick="closePicLibraryModal();">{$t["btn.save_exit"]}</button>
      </div>
    </div>
  </div>
</div>



      
