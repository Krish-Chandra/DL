<?php
	$this->pageTitle = Yii::app()->name . ' - Roles';
?>

<hr class="space">
</hr>
<div class="span-4 box" id="mainNav">
	<h2 class="large box-head"><strong>Tasks</strong></h2>

	<ul>
		<a  href="<?php echo Yii::app()->createUrl('admin/role/createRole');?>">Add a New Role</a>	
	</ul>

</div>


<?php 
	if (isset($dataProvider->data) && !empty($dataProvider->data))
	{
?>	

		<div class="span-16 box" id="gridDiv">
		
			<h2 class="large box-head"><strong>Admin Roles</strong></h2> 
			
<?php	
			$this->widget
			(
				'zii.widgets.grid.CGridView',
				array
				(
					'id'=>'rolesGrid',
					'dataProvider'=>$dataProvider,
					'itemsCssClass' => 'table small',
					'columns' =>array
								(
										array
										(
											'class' => 'CLinkColumn',
											'header' => 'Role Name',
											'labelExpression' => '$data->rolename',
											'urlExpression' => 'Yii::app()->createUrl("admin/user/usersInRole", array("id" =>  $data["id"]))',
										),
		
										array('name' => 'description', 'value' => '$data->description', 'sortable' => false),
										array
										(
											'header' => 'Tasks',
											'class' => 'CDLButtonColumn',
											'template' => '{update} {delete}',
											'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/images/del.gif',
											'deleteConfirmation' => 'Do you want to delete the Role?',
											'deleteButtonUrl' => 'Yii::app()->createUrl("admin/role/deleteRole", array("id" =>  $data["id"]))',
											'updateButtonImageUrl' => Yii::app()->request->baseUrl. '/images/edit.gif',
											'updateButtonUrl' => 'Yii::app()->createUrl("admin/role/updateRole", array("id" =>  $data["id"]))',
											'afterDelete'=>'function(link, success, data)
											{ 
												if(success) 
												{
													$("#StatusMsg").html(data); 
													if (($("#rolesGrid tbody tr").length <= 1) && ($("#StatusMsg div").hasClass(\'msg-ok\')))
													{
														$("#gridDiv").hide();
													}
												}
											}',													
											
										)				
								)
				)
			);

?>
		</div>						

<?php		
	}
?>

