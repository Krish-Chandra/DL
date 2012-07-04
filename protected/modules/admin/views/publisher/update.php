<?php
	$this->pageTitle = Yii::app()->name . ' - Update Publisher';
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'formId' => $formId)); ?>