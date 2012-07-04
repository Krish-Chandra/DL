<?php
	$this->pageTitle = Yii::app()->name . ' - Add Publisher';
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'formId' => $formId)); ?>