<div region="center" border="false">
<div style="padding:20px">
<div id="search-panel" class="easyui-panel" data-options="title:'<?php  echo lang('event_search')?>',collapsible:true,iconCls:'icon-search'" style="padding:5px">
<form action="" method="post" id="event-search-form">
<table width="100%" border="1" cellspacing="1" cellpadding="1">
<tr><td><label><?php echo lang('event_title')?></label>:</td>
<td><input type="text" name="search[event_title]" id="search_event_title"  class="easyui-validatebox"/></td>
<td><label><?php echo lang('venue_id')?></label>:</td>
<td><input type="text" name="search[venue_id]" id="search_venue_id"  class=""/></td>
</tr>
<tr>
<td><label><?php echo lang('user_id')?></label>:</td>
<td><input type="text" name="search[user_id]" id="search_user_id"  class="easyui-numberbox"/></td>
<td><label><?php echo lang('start_date')?></label>:</td>
<td><input type="text" name="date[start_date][from]" id="search_start_date_from"  class="easyui-datebox"/> ~ <input type="text" name="date[start_date][to]" id="search_start_date_to"  class="easyui-datebox"/></td>
</tr>
<tr>
<td><label><?php echo lang('end_date')?></label>:</td>
<td><input type="text" name="date[end_date][from]" id="search_end_date_from"  class="easyui-datebox"/> ~ <input type="text" name="date[end_date][to]" id="search_end_date_to"  class="easyui-datebox"/></td>
<td><label><?php echo lang('status')?></label>:</td>
<td><input type="radio" name="search[status]" id="search_status1" value="1"/><?php echo lang('general_yes')?>
									<input type="radio" name="search[status]" id="search_status0" value="0"/><?php echo lang('general_no')?></td>
</tr>
<tr>
</tr>
  <tr>
    <td colspan="4">
    <a href="javascript:void(0)" class="easyui-linkbutton" id="search" data-options="iconCls:'icon-search'"><?php  echo lang('search')?></a>  
    <a href="javascript:void(0)" class="easyui-linkbutton" id="clear" data-options="iconCls:'icon-clear'"><?php  echo lang('clear')?></a>
    </td>
    </tr>
</table>

</form>
</div>
<br/>
<table id="event-table" data-options="pagination:true,title:'<?php  echo lang('event')?>',pagesize:'20', rownumbers:true,toolbar:'#toolbar',collapsible:true,fitColumns:true">
    <thead>
    <th data-options="field:'checkbox',checkbox:true"></th>
    <th data-options="field:'event_id',sortable:true" width="30"><?php echo lang('event_id')?></th>
<th data-options="field:'event_title',sortable:true" width="50"><?php echo lang('event_title')?></th>
<th data-options="field:'event_image',sortable:true" width="50"><?php echo lang('event_image')?></th>
<th data-options="field:'venue_name',sortable:true" width="50"><?php echo lang('venue_id')?></th>
<th data-options="field:'user_id',sortable:true" width="50"><?php echo lang('user_id')?></th>
<th data-options="field:'start_date',sortable:true" width="50"><?php echo lang('start_date')?></th>
<th data-options="field:'end_date',sortable:true" width="50"><?php echo lang('end_date')?></th>
<th data-options="field:'status',sortable:true,formatter:formatStatus" width="30" align="center"><?php echo lang('status')?></th>

    <th field="action" width="100" formatter="getActions"><?php  echo lang('action')?></th>
    </thead>
</table>

<div id="toolbar" style="padding:5px;height:auto">
    <p>
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="create()" title="<?php  echo lang('create_event')?>"><?php  echo lang('create')?></a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-cancel" plain="false" onclick="removeSelected()"  title="<?php  echo lang('delete_event')?>"><?php  echo lang('remove_selected')?></a>
    </p>

</div> 

<!--for create and edit event form-->
<div id="dlg" class="easyui-dialog" style="width:600px;height:auto;padding:10px 20px"
        data-options="closed:true,collapsible:true,buttons:'#dlg-buttons',modal:true">
    <form id="form-event" method="post" >
    <table>
		<tr>
		              <td width="34%" ><label><?php echo lang('event_title')?>:</label></td>
					  <td width="66%"><input name="event_title" id="event_title" class="easyui-validatebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?php echo lang('description')?>:</label></td>
					  <td width="66%"><textarea name="description" id="description" class="easyui-validatebox" required="true" style="width:300px;height:100px"></textarea></td>
		       </tr><tr>
		              <td width="34%" ><label><?php echo lang('event_image')?>:</label></td>
					  <td width="66%"><label id="upload_image_name" style="display:none"></label>
                      <input name="event_image" id="event_image" type="text" style="display:none"/>
                      <input type="file" id="upload_image" name="userfile" style="display:block"/>
                      <a href="#" id="change-image" title="Delete" style="display:none"><img src="<?=base_url()?>assets/icons/delete.png" border="0"/></a></td>
		       </tr><tr>
		              <td width="34%" ><label><?php echo lang('venue_id')?>:</label></td>
					  <td width="66%"><input name="venue_id" id="venue_id" class="easyui-combobox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?php echo lang('user_id')?>:</label></td>
					  <td width="66%"><input name="user_id" id="user_id" class="easyui-numberbox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?php echo lang('start_date')?>:</label></td>
					  <td width="66%"><input name="start_date" id="start_date" class="easyui-datetimebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?php echo lang('end_date')?>:</label></td>
					  <td width="66%"><input name="end_date" id="end_date" class="easyui-datetimebox" required="true"></td>
		       </tr><tr>
		              <td width="34%" ><label><?php echo lang('status')?>:</label></td>
					  <td width="66%"><input type="radio" value="1" name="status" id="status1" /><?php echo lang("general_yes")?> <input type="radio" value="0" name="status" id="status0" /><?php echo lang("general_no")?></td>
		       </tr><input type="hidden" name="event_id" id="event_id"/>
    </table>
    </form>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onClick="save()"><?php  echo  lang('general_save')?></a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onClick="javascript:$('#dlg').window('close')"><?php  echo  lang('general_cancel')?></a>
	</div>    
</div>
<!--div ends-->
   
</div>
</div>
<script language="javascript" type="text/javascript">
	$(function(){
		
		<?php 
			easyui_combobox('search_venue_id','VENUE');
			easyui_combobox('venue_id','VENUE')
		?>
		$('#clear').click(function(){
			$('#event-search-form').form('clear');
			$('#event-table').datagrid({
				queryParams:null
				});

		});

		$('#search').click(function(){
			$('#event-table').datagrid({
				queryParams:{data:$('#event-search-form').serialize()}
				});
		});		
		$('#event-table').datagrid({
			url:'<?php  echo site_url('event/admin/event/json')?>',
			height:'auto',
			width:'auto',
			onDblClickRow:function(index,row)
			{
				edit(index);
			}
		});
	});
	
	function getActions(value,row,index)
	{
		var e = '<a href="#" onclick="edit('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-edit"  title="<?php  echo lang('edit_event')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-edit"></span></span></a>';
		var d = '<a href="#" onclick="removeevent('+index+')" class="easyui-linkbutton l-btn" iconcls="icon-remove"  title="<?php  echo lang('delete_event')?>"><span class="l-btn-left"><span style="padding-left: 20px;" class="l-btn-text icon-cancel"></span></span></a>';
		return e+d;		
	}
	
	function formatStatus(value)
	{
		if(value==1)
		{
			return 'Yes';
		}
		return 'No';
	}

	function create(){
		//Create code here
		$('#form-event').form('clear');
		$('#dlg').window('open').window('setTitle','<?php  echo lang('create_event')?>');
		//uploadReady(); //Uncomment This function if ajax uploading
	}	

	function edit(index)
	{
		var row = $('#event-table').datagrid('getRows')[index];
		if (row){
			$('#form-event').form('load',row);
			//uploadReady(); //Uncomment This function if ajax uploading
			$('#dlg').window('open').window('setTitle','<?php  echo lang('edit_event')?>');
		}
		else
		{
			$.messager.alert('Error','<?php  echo lang('edit_selection_error')?>');				
		}		
	}
	
		
	function removeevent(index)
	{
		$.messager.confirm('Confirm','<?php  echo lang('delete_confirm')?>',function(r){
			if (r){
				var row = $('#event-table').datagrid('getRows')[index];
				$.post('<?php  echo site_url('event/admin/event/delete_json')?>', {id:[row.event_id]}, function(){
					$('#event-table').datagrid('deleteRow', index);
					$('#event-table').datagrid('reload');
				});

			}
		});
	}
	
	function removeSelected()
	{
		var rows=$('#event-table').datagrid('getSelections');
		if(rows.length>0)
		{
			selected=[];
			for(i=0;i<rows.length;i++)
			{
				selected.push(rows[i].event_id);
			}
			
			$.messager.confirm('Confirm','<?php  echo lang('delete_confirm')?>',function(r){
				if(r){				
					$.post('<?php  echo site_url('event/admin/event/delete_json')?>',{id:selected},function(data){
						$('#event-table').datagrid('reload');
					});
				}
				
			});
			
		}
		else
		{
			$.messager.alert('Error','<?php  echo lang('edit_selection_error')?>');	
		}
		
	}
	
	function save()
	{
		$('#form-event').form('submit',{
			url: '<?php  echo site_url('event/admin/event/save')?>',
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.success)
				{
					$('#form-event').form('clear');
					$('#dlg').window('close');		// close the dialog
					$.messager.show({title: '<?php  echo lang('success')?>',msg: result.msg});
					$('#event-table').datagrid('reload');	// reload the user data
				} 
				else 
				{
					$.messager.show({title: '<?php  echo lang('error')?>',msg: result.msg});
				} //if close
			}//success close
		
		});		
		
	}
	
	function uploadReady()
	{
		uploader=$('#upload_image');
		new AjaxUpload(uploader, {
			action: '<?php  echo site_url('event/admin/event/upload_image')?>',
			name: 'userfile',
			responseType: "json",
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					$.messager.show({title: '<?php  echo lang('error')?>',msg: 'Only JPG, PNG or GIF files are allowed'});
					return false;
				}
				//status.text('Uploading...');
			},
			onComplete: function(file, response){
				if(response.error==null){
					var filename = response.file_name;
					$('#upload_image').hide();
					$('#event_image').val(filename);
					$('#upload_image_name').html(filename);
					$('#upload_image_name').show();
					$('#change-image').show();
				}
                else
                {
					$.messager.show({title: '<?php  echo lang('error')?>',msg: response.error});                
                }
			}		
		});		
	}
</script>