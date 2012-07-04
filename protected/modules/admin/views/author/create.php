<?php
	$this->pageTitle = Yii::app()->name . ' - Add Author';
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'formId' => $formId)); ?>