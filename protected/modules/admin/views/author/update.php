<?php
	$this->pageTitle = Yii::app()->name . ' - Update Author';
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'formId' => $formId)); ?>