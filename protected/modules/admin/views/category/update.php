<?php
	$this->pageTitle = Yii::app()->name . ' - Update Category';
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'formId' => $formId)); ?>