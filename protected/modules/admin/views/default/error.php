<?php
	$this->pageTitle = Yii::app()->name . ' - Error';
?>

<div class='msg msg-error prepend-top'>
	<p>
		<strong>
				<?php echo $error['message']; ?>
		</strong>
	</p>
</div>
