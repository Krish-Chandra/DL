<?php
	$this->pageTitle = Yii::app()->name . ' - Authors';
?>

<div class="add-button box span-4 append-bottom prepend-top">
<a href="<?php echo Yii::app()->createUrl('admin/author/createAuthor');?>">Add a New Author</a>
</div>

<?php 
	if (isset($dataProvider->data) && !empty($dataProvider->data))
	{
?>	
		<div class="span-21 box" id="gridDiv">
			<h2 class="large box-head"><strong>Authors</strong></h2> 
<?php	
		$this->widget(
						'zii.widgets.Grid.CGridView',
						array
						(
							'id' => 'authorsGrid',
	    					'dataProvider' => $dataProvider,
							'itemsCssClass' => 'table small',
							'columns' => array(
											'authorname',
											array('name' => 'address', 'value' => '$data->address', 'sortable' => false),
											array('name' => 'city', 'value' => '$data->city', 'sortable' => false),
											array('name' => 'state', 'value' => '$data->state', 'sortable' => false),
											array('name' => 'zip', 'value' => '$data->zip', 'sortable' => false),
											array('name' => 'email_id', 'value' => '$data->email_id', 'sortable' => false),
											array('name' => 'phone', 'value' => '$data->phone', 'sortable' => false),
											array(
													'header' => 'Tasks',
													'class' => 'CButtonColumn',
													'template' => '{update} {delete}',
													'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/images/del.gif',
													'deleteConfirmation' => 'Do you want to delete the Author?',
													'updateButtonImageUrl' => Yii::app()->request->baseUrl. '/images/edit.gif',														
													'deleteButtonUrl' => 'Yii::app()->createUrl("admin/author/deleteAuthor", array("id" =>  $data["id"]))',
													'updateButtonUrl' => 'Yii::app()->createUrl("admin/author/updateAuthor", array("id" =>  $data["id"]))',
													'afterDelete' => 'function(link, success, data)
													{ 
														if(success) 
														{
															$("#StatusMsg").html(data); 
															if (($("#authorsGrid tbody tr").length <= 1) && ($("#StatusMsg div").hasClass(\'msg-ok\')))
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

