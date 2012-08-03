<div class="box span-20 prepend-top">

	<div class="large box-head"><strong><?php echo $model->isNewRecord ? 'Add Book' : 'Edit Book'; ?></strong></div>
<?php 
	$form = $this->beginWidget('CActiveForm', array('id' => $formId, 'enableAjaxValidation' => true, 'enableClientValidation' => true,
								'focus' => array($model, 'title'), 'errorMessageCssClass' => 'errorMsg'));
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
	        <?php echo $form->labelEx($model, 'Categories', array('class' => 'label')); ?>
			<br />
<?php 

			if ($model->isNewRecord	)
			{
				$catKeys = array_keys($categories);			
				//Make sure atleast one category is selected
				//So, remove the "- Select -" item from the first list
		        echo CHtml::dropDownList('Categories[0]', array($catKeys["1"]), array_diff($categories, array("- Select -")));
		        echo CHtml::dropDownList('Categories[1]', '0', $categories);	
		        echo CHtml::dropDownList('Categories[2]', '0', $categories); 
			}			
			else
			{
				$count = sizeof($model->categories);
				for ($indx = 0; $indx < $count; $indx++)
				    echo CHtml::dropDownList(sprintf('Categories[%d]', $indx), array($model->categories[$indx]->id), $categories);
			}
?>			
		</div>
		<div>
<?php			
			echo $form->labelEx($model,'Authors', array('class' => 'label'));
			echo "<br />";
			if ($model->isNewRecord	)
			{
				$authKeys = array_keys($authors);			
				//Make sure atleast one author is selected
				//So, remove the "- Select -" item from the first list
		        echo CHtml::dropDownList('Authors[0]', array($authKeys["1"]), array_diff($authors, array("- Select -")));
		        echo CHtml::dropDownList('Authors[1]', null, $authors);	
		        echo CHtml::dropDownList('Authors[2]', null, $authors);
			}
			else
			{
				$count = sizeof($model->authors);
				for ($indx = 0; $indx < $count; $indx++)
				    echo CHtml::dropDownList(sprintf('Authors[%d]', $indx), array($model->authors[$indx]->id), $authors);
			}
?>			
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



