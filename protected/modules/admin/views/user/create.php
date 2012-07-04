<?php
	$this->pageTitle = Yii::app()->name . ' - Add User';
?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'roles' => $roles, 'formId' => $formId)); ?>