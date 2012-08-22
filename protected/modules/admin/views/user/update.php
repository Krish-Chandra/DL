<?php
	$this->pageTitle = Yii::app()->name . ' - Update User';
?>

<div class="box span-20 prepend-top">
	<div class="large box-head"><strong>Edit Admin User</strong></div>
<?php 
	$form = $this->beginWidget('CActiveForm', array('id' => $formId, 'enableAjaxValidation' => true, 'enableClientValidation' => true,
								'errorMessageCssClass' => 'errorMsg'));
?>

    	<!--<?php echo $form->errorSummary($model); ?> -->

		<div>
	        <?php echo $form->labelEx($model, 'username'); ?>
			<br />
	        <?php echo $form->textField($model, 'username', array('size' => 60, 'maxlength' => 100 , 'disabled' => 'disabled')); ?>
		</div>
		<div>
	        <?php echo $form->labelEx($model, 'password', array('class' => 'label')); ?>
			<br />
	        <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 100 , 'disabled' => 'disabled')); ?>
		</div>
		<div>
	        <?php echo $form->labelEx($model, 'email_id', array('class' => 'label')); ?>
			<br />
	        <?php echo $form->textField($model, 'email_id', array('size' => 60, 'maxlength' => 100, 'disabled' => 'disabled')); ?>
		</div>
		
		<div class="row rememberMe">
			<?php echo $form->label($model,'active'); ?>			
			<?php echo $form->checkBox($model,'active', array('disabled' => "{$model->username}" == 'administrator' ? TRUE : FALSE)); ?>
		</div>
		<hr class="space" />
<?php			
		$this->widget('zii.widgets.jui.CJuiButton', array(
		    'buttonType' => 'submit',
		    'name' => 'btnSubmit',
		    'value' => '1',
		    'caption' => 'Update',
			'htmlOptions' => array('disabled' => "{$model->username}" == 'administrator' ? TRUE : FALSE),
		));
?>				
    </div>

<?php $this->endWidget(); ?>	
