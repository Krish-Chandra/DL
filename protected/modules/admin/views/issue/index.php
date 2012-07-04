<?php
$this->pageTitle = Yii::app()->name . ' - Issues';
?>

<?php 
	if (isset($dataProvider->data) && !empty($dataProvider->data))
	{
?>	
		<div class="span-21 box" id="gridDiv">
			<h2 class="large box-head"><strong>Issues</strong></h2> 
<?php	
		$this->widget(
						'zii.widgets.Grid.CGridView',
						array
						(
							'id' => 'issuesGrid',
	    					'dataProvider' => $dataProvider,
							'itemsCssClass' => 'table small',
							'columns' => array(
												array('name' => 'Issued To', 'value' => '$data->user->username'),
												array('name' => 'Title', 'value' => '$data->book->title'),
												array('name' => 'Issued On', 'value' => '$data->issue_date'),									
												array('name' => 'Due On', 'value' => '$data->due_date'),														
												array(
													'header' => 'Returned?',
													'class' => 'CButtonColumn',
													'template' => '{delete}',
													'deleteConfirmation' => 'Has the book been returned by the User?',
													'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/images/msg-ok.gif',
													'deleteButtonUrl' => 'Yii::app()->createUrl("admin/issue/returnBook",
													array("UserId" => $data["user_id"], "BookId" => $data["book_id"] ))',
													'afterDelete' => 'function(link, success, data)
													{ 
														if(success) 
														{
															$("#StatusMsg").html(data); 
															if (($("#issuesGrid tbody tr").length <= 1) && ($("#StatusMsg div").hasClass(\'msg-ok\')))
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

