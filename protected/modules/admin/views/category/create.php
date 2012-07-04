<?php
	$this->pageTitle = Yii::app()->name . ' - Add Category';
?>

<?php echo $this->renderPartial('_form', array('model' => $model,  'formId' => $formId)); ?>