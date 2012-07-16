<?php
	$this->pageTitle = Yii::app()->name . ' - Users';
?>

<hr class="space">
</hr>
<div class="span-5 box" id="mainNav">
	<h2 class="large box-head"><strong>Tasks</strong></h2>

	<ul>
		<img class="left" alt="Library" src="<?php echo Yii::app()->request->baseUrl; ?>/images/user_add.png" />		
		&nbsp;
		<a  href="<?php echo Yii::app()->createUrl('admin/user/createUser');?>">Add a New User</a>	
	</ul>

</div>


<?php 
	if (isset($dataProvider->data) && !empty($dataProvider->data))
	{
?>	

		<div class="span-15 box" id="gridDiv">
		
			<h2 class="large box-head"><strong>Admin Users</strong></h2> 
			
<?php	
			echo CHtml::beginform(Yii::app()->createUrl('admin/users/inactivateUsers'));
				$this->widget
				(
					'zii.widgets.grid.CGridView',
					array
					(
						'id' => 'usersGrid',
						'dataProvider' => $dataProvider,
						'itemsCssClass' => 'table small',
						'columns' => array(
											array('name' => 'User Name', 'value' => '$data->username'),
											array('name' => 'Email ID', 'value' => '$data->email_id'),
											array('name' => 'Registration Date', 'value' => '$data->created_on'),		
											array('header' => 'Active?', 'class' => 'CCheckBoxColumn', 'id' => 'active', 'checked' => '$data->active', 'value' => '$data->id', 'selectableRows' => '0'),
											array(
													'header' => 'Tasks',
													'class' => 'CDLButtonColumn',
													'template' => '{update} {delete}',
													'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/images/user_delete.png',
													'deleteConfirmation' => 'Do you want to delete the Admin User?',
													'deleteButtonUrl' => 'Yii::app()->createUrl("admin/user/deleteUser", array("id" =>  $data["id"]))',										
													'updateButtonImageUrl' => Yii::app()->request->baseUrl. '/images/user_edit.png',					
													'updateButtonUrl' => 'Yii::app()->createUrl("admin/user/updateUser", array("id" =>  $data["id"]))', 
													'afterDelete' => 'function(link, success, data)
													{ 
														if(success) 
														{
															$("#StatusMsg").html(data); 
															if (($("#usersGrid tbody tr").length <= 1) && ($("#StatusMsg div").hasClass(\'msg-ok\')))
															{
																$("#gridDiv").hide();
															}
														}
													}',													
													
												 )				
										
										)
					)
				);
	
			echo CHtml::endForm();
?>				
		</div>						

<?php		
	}
?>

