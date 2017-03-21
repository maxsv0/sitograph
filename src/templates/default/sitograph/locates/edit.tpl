<div>
 
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  

<li role="presentation" class="active"><a href="#loc" aria-controls="loc" role="tab" data-toggle="tab">Название</a></li>

  </ul>
  
<form action="{$lang_url}/admin/" class="form-horizontal" method="POST">
<br>
<br>

  <!-- Tab panes -->
  <div class="tab-content">
  
  
<div role="tabpanel" class="tab-pane active" id="loc">

{include "$themePath/sitograph/field-form.tpl" form_id="form" item_type=$itemField.type item_id=$itemField.field_name item_name=$itemField.name value=$itemField.value}

</div>
  
  </div>
 
<input type="hidden" value="{$admin_section}" name="section">
<input type="hidden" value="{$itemField.item_edit}" id="itemID" name="itemID">
<input type="hidden" value="{$itemField.module}" id="module" name="module">

<div class="form-group">
<div class="text-left">
	<button type="submit" class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove-circle">&nbsp;</span>{$t["btn.cancel"]}</button>
	<button class="btn btn-danger" type="reset"><span class="glyphicon glyphicon-ban-circle">&nbsp;</span>{$t["btn.reset"]}</button>
	<button type="submit" name="save" id="btnSave" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-repeat">&nbsp;</span>{$t["btn.save"]}</button>
	<button type="submit" name="save_exit" value="1" class="btn btn-primary"><span class="glyphicon glyphicon-ok">&nbsp;</span>{$t["btn.save_exit"]}</button>
</div>
</div>
</form>



</div>