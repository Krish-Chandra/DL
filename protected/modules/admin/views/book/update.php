<?php
	$this->pageTitle = Yii::app()->name . ' - Update Book';
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'publishers' => $publishers, 'categories' => $categories, 'authors' => $authors,
	 'formId' => $formId)); ?>