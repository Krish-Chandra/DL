<div class="box span-20 prepend-top">

	<div class="large box-head"><strong><?php echo $model->isNewRecord ? 'Add Book' : 'Edit Book'; ?></strong></div>
<?php 
	$form = $this->beginWidget('CActiveForm', array('id' => $formId, 'enableAjaxValidation' => true, 'enableClientValidation' => true, 'errorMessageCssClass' => 'errorMsg'));
?>

<!--    <p class="note">Fields with <span class="required">*</span> are required.</p> -->

    <!--<?php echo $form->errorSummary($model); ?> -->

		<div>
	        <?php echo $form->labelEx($model,'title', array('class' => 'label')); ?>
			<br />
	        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 100)); ?>
	        <?php echo $form->error($model, 'title'); ?>
		</div>
		<div>
	        <?php echo $form->labelEx($model, 'category_id', array('class' => 'label')); ?>
			<br />
	        <?php echo CHtml::dropDownList('Book[category_id]', $model->category_id, $categories); ?> 
	        <?php echo $form->error($model, 'category_id'); ?>
		</div>
		<div>
	        <?php echo $form->labelEx($model,'author_id', array('class' => 'label')); ?>
			<br />		
	        <?php echo CHtml::dropDownList('Book[author_id]', $model->author_id, $authors); ?> 
	        <?php echo $form->error($model, 'author_id'); ?>
		</div>
		<div>		
	        <?php echo $form->labelEx($model, 'publisher_id', array('class' => 'label')); ?>
			<br />		
	        <?php echo CHtml::dropDownList('Book[publisher_id]', $model->publisher_id, $publishers); ?> 
	        <?php echo $form->error($model, 'publisher_id'); ?>
		</div>
		<div>		
	        <?php echo $form->labelEx($model, 'isbn', array('class' => 'label')); ?>
			<br />		
	        <?php echo $form->textField($model, 'isbn', array('size' => 50, 'maxlength' => 50)); ?>
	        <?php echo $form->error($model, 'isbn'); ?>
		</div>
		<div>
	        <?php echo $form->labelEx($model,'total_copies', array('class' => 'label')); ?>
			<br />		
	        <?php echo $form->textField($model,'total_copies',array('size' => 10, 'maxlength' => 10)); ?>
	        <?php echo $form->error($model,'total_copies'); ?>
		</div>
		<div>		
	        <?php echo $form->labelEx($model,'available_copies', array('class' => 'label')); ?>
			<br />		
	        <?php echo $form->textField($model, 'available_copies', array('size' => 10, 'maxlength' => 10)); ?>
	        <?php echo $form->error($model,'available_copies'); ?>
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



