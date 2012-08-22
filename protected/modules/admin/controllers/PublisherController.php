<?php
	class PublisherController extends Controller
	{
		public $formId = 'publishers-form';
		
	
		public function actionIndex()
		{
	        $dataProvider = Publisher::model()->getAllPublishers();
			$publishers = $dataProvider->data;

			if (empty($publishers))
			{
				$msg = "No Publisher has been added to the system!";
				Yii::app()->user->setFlash('error', $msg);	
			}
			
	        $this->render('index', array('dataProvider' => $dataProvider));
				
		}
		
		
	    public function actionCreatePublisher()
	    {
	        $model = new Publisher;
	
	        // Uncomment the following line if AJAX validation is needed
	        $this->performAjaxValidation($model, $this->formId);
	
	        if(isset($_POST['Publisher']))
	        {
	            $model->attributes=$_POST['Publisher'];
	            if($model->save())
	                $this->redirect('index');
	        }
	
	        $this->render('create', array('model' => $model, 'formId' => $this->formId));
	    }
		
	    public function actionUpdatePublisher($id)
	    {
	        $model = $this->loadPublisherModel($id);
			if($model === null)
			{
				Yii::app()->cache->flush();				
				$msg = "Couldn't complete the operation as the publisher is not found!";
				Yii::app()->user->setFlash('error', $msg);	
				$this->redirect(array('index'));
				
			}
			else
			{
				
		        // Uncomment the following line if AJAX validation is needed
		        $this->performAjaxValidation($model, $this->formId);
		
		        if(isset($_POST['Publisher']))
		        {
		            $model->attributes = $_POST['Publisher'];
					//$model->update_time = date("Y-m-d H:i:s");				
		            if($model->save())
					{
						Yii::app()->user->setFlash('message', "Successfully updated the publisher's details!");
						$this->redirect(array('index'));
					}
					else
					{
						Yii::app()->user->setFlash('error', "Couldn't update the publisher's details!!");	
					}

		        }
		
		        $this->render('update', array('model' => $model, 'formId' => $this->formId));
			}
	    }	
		
		public function actiondeletePublisher($id)
		{
	        if(Yii::app()->request->isPostRequest)
	        {
				$model = $this->loadPublisherModel($id);				
				if ($model === null)
				{
					Yii::app()->cache->flush();				
					$msg = "Couldn't complete the operation as the publisher is not found!";
					echo "<div class='msg msg-error push-1 span-21  prepend-top'><p><strong>".$msg."</strong></p></div>";					
				}
				else
				{
					try
					{
			            if ($model->delete())
						{
							$type = "message";
							$msg = "Successfully deleted the Publisher!";	
			
						}
						else
						{
							$type = "error";
							$msg =  "Couldn't delete the Publisher!";	
						}
					}	
					catch (CDbException $ex)
					{
						$type = "error";
						$msg = "Couldn't delete the Publisher! Check if a book published by this Publisher has been issued to a Member!!";					
					}
			
	
		            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		            if(!isset($_GET['ajax']))
					{
						Yii::app()->cache->flush();
						Yii::app()->user->setFlash($type, $msg);		
						$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
					}
					else
					{
						if (strcasecmp($type, "message") == 0)
						{
							Yii::app()->cache->flush();	
							echo "<div class='msg msg-ok push-1 span-21  prepend-top'><p><strong>".$msg."</strong></p></div>";
						}
						elseif (strcasecmp($type, "error") == 0)
							echo "<div class='msg msg-error push-1 span-21  prepend-top'><p><strong>".$msg."</strong></p></div>";
					}
	        	}
			}
	        else
	            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
		
	    public function loadPublisherModel($id)
	    {
	        $model = Publisher::model()->findByPk($id);
/*	        if($model === null)
	            throw new CHttpException(404, "Couldn't complete the operation"); */
	        return $model;
	    }
		
	}
?>