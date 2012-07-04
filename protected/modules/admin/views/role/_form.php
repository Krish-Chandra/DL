<div class="box span-20 prepend-top">

	<div class="large box-head"><strong><?php echo $model->isNewRecord ? 'Add Role' : 'Edit Role'; ?></strong></div>
<?php 
	$form=$this->beginWidget('CActiveForm', array('id' => $formId, 'enableAjaxValidation' => true, 'enableClientValidation' => true, 'errorMessageCssClass' => 'errorMsg'));
?>

<!--    <?php echo $form->errorSummary($model); ?> -->
    <div>
        <?php echo $form->labelEx($model, 'rolename'); ?>
		<br />
        <?php echo $form->textField($model, 'rolename', array('size' => 60, 'maxlength' => 75, 'disabled' => ((($model->rolename == 'admin') || ($model->rolename == 'supervisor') ) && !$model->isNewRecord) ? TRUE : FALSE)); ?>
        <?php echo $form->error($model, 'rolename'); ?>
    </div>
    <div>
        <?php echo $form->labelEx($model, 'description'); ?>
		<br />
        <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 75)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
	<hr class="space" />
<?php			
	$this->widget('zii.widgets.jui.CJuiButton', array(
	    'buttonType' => 'submit',
	    'name' => 'btnSubmit',
	    'value' => '1',
	    'caption' => $model->isNewRecord ? 'Add' : 'Update',
	));
?>				


<?php $this->endWidget(); ?>	



</div><!-- form -->
