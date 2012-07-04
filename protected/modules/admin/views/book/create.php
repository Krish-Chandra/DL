<?php
	$this->pageTitle = Yii::app()->name . ' - Add Book';
?>

<?php echo $this->renderPartial('admin.views.book._form', array('model'=>$model, 'publishers'=>$publishers, 'categories'=>$categories,
   'authors'=>$authors, 'formId'=>$formId, )); ?>