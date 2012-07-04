<?php
	$this->pageTitle = Yii::app()->name . ' - Requests';
?>

<?php 
	if (isset($dataProvider->data) && !empty($dataProvider->data))
	{
?>	
		<div class="span-21 box" id="gridDiv">
			<h2 class="large box-head"><strong>Requests</strong></h2> 
<?php	
			$this->widget(
							'zii.widgets.Grid.CGridView',
							array
							(
								'id' => 'requestsGrid',
		    					'dataProvider' => $dataProvider,
								'itemsCssClass' => 'table small',	
								'columns' => array(
													array('name' => 'Requested By', 'value'=>'$data->user->username'),
													array('name' => 'Title', 'value'=>'$data->book->title'),
													array('name' => 'Requested On', 'value'=>'$data->date'),	
													array('name' => 'Total Copies', 'value'=>'$data->book->total_copies'),				
													array('name' => 'Available Copies', 'value'=>'$data->book->available_copies'),							
													array(
														'header' => 'Tasks',
														'class' => 'CDLButtonColumn',
														'template' => '{delete}',
														'header' => 'Issue?',
														'deleteButtonLabel' => 'Issue book to the Member',
														'deleteConfirmation' => 'Do you want to issue the book to the Member?',
														'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/images/msg-ok.gif',
														'deleteButtonUrl' => 'Yii::app()->createUrl("admin/request/issueBook",
														array("id" =>  $data["id"], "userId"=>$data["user_id"], "bookId"=>$data["book_id"] ))',
														'afterDelete'=>'function(link, success, data)
														{ 
															if(success) 
															{
																$("#StatusMsg").html(data); 
																if (($("#requestsGrid tbody tr").length <= 1) && ($("#StatusMsg div").hasClass(\'msg-ok\')))
																{
																	$("#gridDiv").hide();
																}
															}
														}',													
														
/*														'buttons'=>array(
														'issue'=>array(
														'url'=>'Yii::app()->createUrl("admin/requests/issueBook", 
																			array(
																					"id" =>  $data["Id"],
																					"bookId"=>$data["BookId"],
																					"userId"=>$data["UserId"]
																			))',
														'imageUrl'=>Yii::app()->request->baseUrl.'/images/msg-ok.gif',
														'visible'=>'$data->book->AvailableCopies > 0',
														
															
														)
	
													 ) */				
												), 
							)
					)	);
			

?>
		</div>						
<?php		
	}
?>

