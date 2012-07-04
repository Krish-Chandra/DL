<?php
$this->pageTitle = Yii::app()->name . ' - Members';
?>

<hr class="space">
</hr>

<?php 
	if (isset($dataProvider->data) && !empty($dataProvider->data))
	{
?>	

		<div class="span-21 box" id="gridDiv">
		
			<h2 class="large box-head"><strong>Library Members</strong></h2> 
			
<?php	
	$this->widget
	(
		'zii.widgets.Grid.CGridView',
		array
		(
			'id' => 'membersGrid',
			'dataProvider' => $dataProvider,
			'itemsCssClass' => 'table small',
			'columns' => array(
								array('name' => 'User ID', 'value' => '$data->username'),
								array('name' => 'Email ID', 'value' => '$data->email_id'),
								array('name' => 'Registration Date', 'value' => '$data->created_on'),		
								array('header' => 'Active?', 'class' => 'CCheckBoxColumn', 'id' => 'active', 'checked' => '$data->active', 'value' => '$data->id', 'selectableRows' => '0'),
								array(
										'header' => 'Tasks',
										'class' => 'CButtonColumn',
										'template' => '{update} {delete}',
										'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/images/user_delete.png',
										'deleteConfirmation' => 'Do you want to delete the Member?',
										'updateButtonImageUrl' => Yii::app()->request->baseUrl. '/images/user_edit.png',					
										'deleteButtonUrl' => 'Yii::app()->createUrl("admin/member/deleteMember", array("id" =>  $data["id"]))',
										'updateButtonUrl' => 'Yii::app()->createUrl("admin/member/updateMember", array("id" =>  $data["id"]))',
										'afterDelete' => 'function(link, success, data)
										{ 
											if(success) 
											{
												$("#StatusMsg").html(data); 
												if (($("#membersGrid tbody tr").length <= 1) && ($("#StatusMsg div").hasClass(\'msg-ok\')))
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

