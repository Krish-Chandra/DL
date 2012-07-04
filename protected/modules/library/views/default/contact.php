<?php
	$this->pageTitle = Yii::app()->name . ' - Contact';
?>

<?php
	$this->pageTitle=Yii::app()->name . ' - Contact Admin';
?>


<?php if(!Yii::app()->user->hasFlash('contact')): ?>

<div class="form">
<?php
	$form=$this->beginWidget('CActiveForm', array('id' => 'contact-form', 'enableClientValidation' => true, 'enableAjaxValidation' => true, 'errorMessageCssClass'=>'errorMsg',));
?>
	<div class="span-21 box">
		<h2 class="large box-head"><strong>Contact Admin</strong></h2> 	
	
<!--		<?php echo $form->errorSummary($model); ?> -->
	
		<div>
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name'); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
		<div>
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email'); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
	
		<div>
			<?php echo $form->labelEx($model,'subject'); ?>
			<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
			<?php echo $form->error($model,'subject'); ?>
		</div>
	
		<div >
			<?php echo $form->labelEx($model,'body'); ?>
			<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'body'); ?>
		</div>
	
		<?php if(CCaptcha::checkRequirements()): ?>
		<div >
			<?php echo $form->labelEx($model,'verifyCode'); ?>
			<div>
			<?php $this->widget('CCaptcha'); ?>
			<?php echo $form->textField($model,'verifyCode'); ?>
			</div>
			<div class="hint">Please enter the letters as they are shown in the image above.
			<br/>Letters are not case-sensitive.</div>
			<?php echo $form->error($model,'verifyCode'); ?>
		</div>
		<?php endif; ?>
		<hr class="space" />
		<div class="">
<?php			
				$this->widget('zii.widgets.jui.CJuiButton', array(
				    'buttonType'=>'submit',
				    'name'=>'btnSubmit',
				    'value'=>'1',
				    'caption'=>'Submit',
				));
?>				
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>