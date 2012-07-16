<?php
	$this->pageTitle = Yii::app()->name . ' - Publishers';
?>

<div class="add-button box span-4 append-bottom prepend-top">
	<a href="<?php echo Yii::app()->createUrl('admin/publisher/createPublisher');?>">Add a New Publisher</a>
</div>

<?php 
	if (isset($dataProvider->data) && !empty($dataProvider->data))
	{
?>	
		<div class="span-21 box" id="gridDiv">
			<h2 class="large box-head"><strong>Publishers</strong></h2> 
<?php	
		$this->widget(
						'zii.widgets.grid.CGridView',
						array
						(
							'id' => 'publishersGrid',
	    					'dataProvider'=>$dataProvider,
							'itemsCssClass' => 'table small',
							'columns'=>array(
												'publishername',
												array('name' => 'Address', 'value' => '$data->address', 'sortable' => false),
												array('name' => 'City', 'value' => '$data->city', 'sortable' => false),
												array('name' => 'State', 'value' => '$data->state', 'sortable' => false),
												array('name' => 'Zip', 'value' => '$data->zip', 'sortable' => false),
												array('name' => 'Email ID', 'value' => '$data->email_id', 'sortable' => false),
												array('name' => 'Phone', 'value' => '$data->phone', 'sortable' => false),
												array(
														'header'=>'Tasks',
														'class'=>'CButtonColumn',
														'template'=>'{update} {delete}',
														'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/images/del.gif',
														'deleteConfirmation' => 'Do you want to delete the Publisher?',
														'updateButtonImageUrl' => Yii::app()->request->baseUrl. '/images/edit.gif',
														'deleteButtonUrl'=>'Yii::app()->createUrl("admin/publisher/deletePublisher",
														 array("id" =>  $data["id"]))',
														'updateButtonUrl'=>'Yii::app()->createUrl("admin/publisher/updatePublisher",
														 array("id" =>  $data["id"]))',
														'afterDelete' => 'function(link, success, data)
														{
															 if(success)
															 {
															 	$("#StatusMsg").html(data); 
																if (($("#publishersGrid tbody tr").length <= 1) && ($("#StatusMsg div").hasClass(\'msg-ok\')))
																{
																	$("#gridDiv").hide();
																}
																
															}
														}',
													 )				
											),
						)
					);

?>
		</div>						
<?php		
	}
?>

