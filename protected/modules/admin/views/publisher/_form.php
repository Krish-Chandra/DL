<div class="box span-20 prepend-top">


	<div class="large box-head"><strong><?php echo $model->isNewRecord ? 'Add Publisher' : 'Edit Publisher'; ?></strong></div>
<?php 
	$form = $this->beginWidget('CActiveForm', array('id' => $formId, 'enableAjaxValidation' => true, 'enableClientValidation' => true, 'errorMessageCssClass' => 'errorMsg'));
?>

<!--    <p class="note">Fields with <span class="required">*</span> are required.</p> -->

<!--    <?php echo $form->errorSummary($model); ?> -->

		    <div >
		        <?php echo $form->labelEx($model, 'publishername'); ?>
				<br />
		        <?php echo $form->textField($model, 'publishername', array('size' => 50, 'maxlength' => 50)); ?>
		        <?php echo $form->error($model, 'publishername'); ?>
		    </div>
		
		    <div >
		        <?php echo $form->labelEx($model,'address'); ?>
				<br />				
		        <?php echo $form->textField($model, 'address', array('size' => 60, 'maxlength' => 100)); ?>
		        <?php echo $form->error($model, 'address'); ?>
		    </div>
		
		    <div>
		        <?php echo $form->labelEx($model, 'city'); ?>
				<br />				
		        <?php echo $form->textField($model, 'city', array('size' => 25, 'maxlength' => 25)); ?>
		        <?php echo $form->error($model, 'city'); ?>
		    </div>
		
		    <div>
		        <?php echo $form->labelEx($model, 'state'); ?>
				<br />				
		        <?php echo $form->textField($model, 'state', array('size' => 10, 'maxlength' => 10)); ?>
		        <?php echo $form->error($model, 'state'); ?>
		    </div>
		
		    <div>
		        <?php echo $form->labelEx($model, 'zip'); ?>
				<br />				
		        <?php echo $form->textField($model, 'zip', array('size' => 10, 'maxlength' => 10)); ?>
		        <?php echo $form->error($model,'zip'); ?>
		    </div>
		
		    <div>
		        <?php echo $form->labelEx($model, 'email_id'); ?>
				<br />				
		        <?php echo $form->textField($model, 'email_id', array('size' => 25, 'maxlength' => 25)); ?>
		        <?php echo $form->error($model, 'email_id'); ?>
		    </div>
		
		    <div>
		        <?php echo $form->labelEx($model, 'phone'); ?>
				<br />				
		        <?php echo $form->textField($model, 'phone', array('size' => 20, 'maxlength' => 20)); ?>
		        <?php echo $form->error($model, 'phone'); ?>
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

    </div>

<?php $this->endWidget(); ?>	


