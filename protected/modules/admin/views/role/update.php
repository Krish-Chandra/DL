<?php
	$this->pageTitle = Yii::app()->name . ' - Update Role';
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'formId' => $formId)); ?>