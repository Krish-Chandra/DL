<?php
	$this->pageTitle = Yii::app()->name . ' - Categories';
?>

<div class="add-button box span-4 append-bottom prepend-top">
<a href="<?php echo Yii::app()->createUrl('admin/category/createCategory');?>">Add a New Category	</a>
</div>

<?php 
	if (isset($dataProvider->data) && !empty($dataProvider->data))
	{
?>	
		<div class="span-21 box" id="gridDiv">
			<h2 class="large box-head"><strong>Categories</strong></h2> 
<?php	
		$this->widget(
						'zii.widgets.grid.CGridView',
						array
						(
							'id' => 'categoriesGrid',
	    					'dataProvider' => $dataProvider,
							'itemsCssClass' => 'table small',							
							'columns' => array(
											'categoryname',
											array(
													'header' => 'Tasks',
													'class' => 'CButtonColumn',
													'template' => '{update} {delete}',
													'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/images/del.gif',
													'deleteConfirmation' => 'Do you want to delete the Category?',													
													'updateButtonImageUrl' => Yii::app()->request->baseUrl. '/images/edit.gif',
													'deleteButtonUrl' => 'Yii::app()->createUrl("admin/category/deleteCategory",
													array("id" =>  $data["id"]))',
													'updateButtonUrl' => 'Yii::app()->createUrl("admin/category/updateCategory",
													array("id" =>  $data["id"]))',
													'afterDelete' => 'function(link, success, data)
													{ 
														if(success) 
														{
															$("#StatusMsg").html(data); 
															if (($("#categoriesGrid tbody tr").length <= 1) && ($("#StatusMsg div").hasClass(\'msg-ok\')))
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
