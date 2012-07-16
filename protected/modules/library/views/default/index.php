<?php
	$this->pageTitle = Yii::app()->name . ' - Books Catalog';
?>

<?php 
	if (isset($dataProvider->data) && !empty($dataProvider->data))
	{
?>	
		<div class="span-21 box prepend-top">
			<h2 class="large box-head"><strong>Books Catalog</strong></h2> 
<?php	
//			echo CHtml::beginform(Yii::app()->createUrl('library/default/addToReqCart'));
			$this->widget(
							'zii.widgets.grid.CGridView',
							array
							(
								'id' => 'booksCatalogGrid',
		    					'dataProvider' => $dataProvider,
								'itemsCssClass' => 'table small',
								'selectableRows' => 'null',
								'columns' => array(
													'title',
													array('name' => 'Category', 'value' => '$data->category->categoryname'),
													array('name' => 'Author', 'value' => '$data->author->authorname'),									
													array('name' => 'Publisher', 'value' => '$data->publisher->publishername'),
													array('name' => 'ISBN', 'value' => '$data->isbn', 'header' => 'ISBN'),
													array('name' => 'Total', 'value' => '$data->total_copies'),
													array('name' => 'Available', 'value' => '$data->available_copies'),
													//array('class'=>'CMyCheckBoxColumn', 'id'=>'select', 'value'=>'$data->id', 'selectableRows'=>'2')
													array(
															'header' => 'Add?',
															'class' => 'CButtonColumn',
															'template' => '{update}',
															'updateButtonLabel' => 'Add the book to your request cart',															
															'updateButtonImageUrl' => Yii::app()->request->baseUrl. '/images/msg-ok.gif',
															'updateButtonUrl' => 'Yii::app()->createUrl(\'library/default/addToReqCart\',
															array("bookId" => $data["id"] ))',
														 )				
												)
							)
						);

?>
		<div class="push-10">
<!--			<INPUT TYPE="image" SRC=<?php echo Yii::app()->request->baseUrl.'/images/basket_put.png'; ?>  WIDTH="16"  HEIGHT="16" title="Add selected book(s) to your request cart" /> -->
			<a href="<?php echo Yii::app()->createUrl('library/default/viewReqCart'); ?>" ><img  src=<?php echo Yii::app()->request->baseUrl.'/images/basket.png'; ?>  title="View your request cart"  width="16" height="16">
			</a>
		</div>
	</div>								
<?php		
//		echo CHtml::endForm();
	}
?>

