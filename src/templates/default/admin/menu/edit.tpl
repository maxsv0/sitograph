
{include "$themePath/admin/form-table.tpl" dataList=$admin_edit}






<script>
$(document).ready(function() {
		
	$('#istructure_id').on('change', function() {
		var id = this.value;
		
		$("#iurl").val(structure_url[id]);
		$("#iname").val(structure_name[id]);
	});
	
structure_url = {};
structure_name = {};
{foreach from=$structure name=loop item=item}
structure_url[{$item.id}] = '{$item.url}';
structure_name[{$item.id}] = '{$item.name}';
{/foreach}
	
});
</script>
