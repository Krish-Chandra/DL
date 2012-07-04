<div class="box span-20 prepend-top">

	<div class="large box-head"><strong><?php echo $model->isNewRecord ? 'Add Category' : 'Edit Category'; ?></strong></div>
<?php 
	$form=$this->beginWidget('CActiveForm', array('id' => $formId,   'enableAjaxValidation' => true, 'enableClientValidation' => true, 'errorMessageCssClass' => 'errorMsg'));
?>

<!--    <p class="note">Fields with <span class="required">*</span> are required.</p> -->

<!--    <?php echo $form->errorSummary($model); ?> -->
    <div>
        <?php echo $form->labelEx($model,'categoryname'); ?>
		<br />
        <?php echo $form->textField($model, 'categoryname', array('size' => 60, 'maxlength' => 75)); ?>
        <?php echo $form->error($model, 'categoryname'); ?>
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
