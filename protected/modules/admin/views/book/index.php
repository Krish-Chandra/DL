<?php
	$this->pageTitle = Yii::app()->name . ' - Books';
?>

<?php
if ($canAddNewBook)
{
?>
	<div class="add-button box span-4 append-bottom prepend-top">
		<a  href="<?php echo Yii::app()->createUrl('admin/book/createBook');?>">Add a New Book</a>	
	</div>
<?php	
}
?>

<?php 
	if (isset($dataProvider->data) && !empty($dataProvider->data))
	{
?>	
		<div class="span-21 box" id="gridDiv">
			<h2 class="large box-head"><strong>Books</strong></h2> 
<?php	
			$this->widget(
							'zii.widgets.grid.CGridView',
							array
							(
								'id' => 'booksGrid',
		    					'dataProvider' => $dataProvider,
								'itemsCssClass' => 'table small',
								'columns' => array
								(
									'title',
									array('name' => 'Categories', 'class' =>'CDLDataColumn', 'sortable' => false),									
									array('name' => 'Authors', 'class' => 'CDLDataColumn', 'sortable' => false),									
									array('name' => 'Publisher', 'value' => '$data->publisher->publishername', 'sortable' => false),																					
									'isbn',
									array('name' => 'Total', 'value' => '$data->total_copies', 'sortable' => false),
									array('name' => 'Available', 'value' => '$data->available_copies', 'sortable' => false),
									array
									(
										'header' => 'Tasks',
										'class' => 'CButtonColumn',
										'template' => '{update} {delete}',
										'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/images/del.gif',
										'deleteConfirmation' => 'Do you want to delete the Book?',
										'updateButtonImageUrl' => Yii::app()->request->baseUrl. '/images/edit.gif',					
										'deleteButtonUrl' => 'Yii::app()->createUrl("admin/book/deleteBook", array("id" =>  $data["id"]))',
										'updateButtonUrl' => 'Yii::app()->createUrl("admin/book/updateBook", array("id" =>  $data["id"]))',
										'afterDelete' => 'function(link,success,data)
										{ 
											if(success)
											{
												$("#StatusMsg").html(data);
												if (($("#booksGrid tbody tr").length <= 1) && ($("#StatusMsg div").hasClass(\'msg-ok\')))
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
