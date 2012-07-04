<?php
	$this->pageTitle = Yii::app()->name . ' - View Requestcart';
?>

<?php 
	if (isset($dataProvider->data) && !empty($dataProvider->data))
	{
?>	
		<div class="span-21 box" id="gridDiv">
			<h2 class="large box-head"><strong>Request Cart</strong></h2> 
<?php	
				$this->widget(
								'zii.widgets.Grid.CGridView',
								array
								(
									'id' => 'viewReqCartGrid',
			    					'dataProvider' => $dataProvider,
									'itemsCssClass' => 'table small',
									'selectableRows' => '2',
									'columns' => array(
														'title',
														array('name' => 'Category', 'value' => '$data->category->categoryname'),
														array('name' => 'Author', 'value' => '$data->author->authorname'),									
														array('name' => 'Publisher', 'value' => '$data->publisher->publishername'),																					
														array('name' => 'ISBN', 'value' => '$data->isbn', 'header' => 'ISBN'),
														array('name' => 'Total', 'value' => '$data->total_copies'),
														array('name' => 'Available', 'value' => '$data->available_copies'),
														array(
															'header' => 'Remove?',
															'class' => 'CButtonColumn',
															'template' => '{delete}',
															'deleteConfirmation' => 'Do you want to remove the book from the request cart?',
															'deleteButtonImageUrl' => Yii::app()->request->baseUrl. '/images/del.gif',
															'deleteButtonUrl' => 'Yii::app()->createUrl(\'library/default/removeFromReqCart\',
															array("bookId" => $data["id"] ))',
															'afterDelete' => 'function(link, success, data)
															{ 
																if(success) 
																{
																	$("#StatusMsg").html(data); 
																	if (($("#viewReqCartGrid tbody tr").length <= 1) && ($("#StatusMsg div").hasClass(\'msg-ok\')))
																	{
																		$("#gridDiv").hide();
																	}
																}
															}',													
														 )				
								)
							));
?>					
			<div class="push-2">
				<div id="linkimg" class="push-8">
<!--					<INPUT TYPE="image" SRC=<?php echo Yii::app()->request->baseUrl.'/images/basket_remove.png'; ?> WIDTH="16"  HEIGHT="16"  title="Remove selected book(s) from your request cart"
					 ALT="SUBMIT!" /> -->
					<a  href="<?php echo Yii::app()->createUrl('library/default/checkout'); ?>" >
					<img src=<?php echo Yii::app()->request->baseUrl.'/images/basket_go.png'; ?> title = "Make a request for the books in your cart" ></a>
				</div>
			</div>

			</div>	
<?php
	}
?>

		
	
