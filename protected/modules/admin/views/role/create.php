<?php
	$this->pageTitle = Yii::app()->name . ' - Add Role';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'formId' => $formId)); ?>