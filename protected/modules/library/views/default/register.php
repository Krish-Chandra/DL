<?php
	$this->pageTitle = Yii::app()->name . ' - Sign Up';
?>

<div class="form">
<?php
	$form=$this->beginWidget('CActiveForm', array('id' => 'register-form', 'enableAjaxValidation' => true, 'enableClientValidation' => true, 'errorMessageCssClass' => 'errorMsg')); 
?>
		<div class="span-21 box">
			<h2 class="large box-head"><strong>Sign Up</strong></h2> 

			<div>
				<?php echo $form->labelEx($model,'username'); ?>
				<?php echo $form->textField($model,'username'); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>
		
			<div>
				<?php echo $form->labelEx($model,'password'); ?>
				<?php echo $form->passwordField($model,'password'); ?>
				<?php echo $form->error($model,'password'); ?>
			</div>

			<div>
				<?php echo $form->labelEx($model,'password_2'); ?>
				<?php echo $form->passwordField($model,'password_2'); ?>
				<?php echo $form->error($model,'password_2'); ?>
			</div>

			<div>
				<?php echo $form->labelEx($model,'email_id'); ?>
				<?php echo $form->textField($model,'email_id'); ?>
				<?php echo $form->error($model,'email_id'); ?>
			</div>

			<br class="space" />
<?php			
			$this->widget('zii.widgets.jui.CJuiButton', array(
			    'buttonType'=>'submit',
			    'name'=>'btnSubmit',
			    'value'=>'1',
			    'caption'=>'SignUp',
			));
?>				
	</div>


<?php $this->endWidget(); ?>
</div><!-- form -->

