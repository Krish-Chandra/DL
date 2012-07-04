<?php
	class PublisherController extends Controller
	{
		public $formId = 'publishers-form';
		
		public function accessRules()
		{
	
			return array(
							array('allow','roles' => array('admin', 'supervisor')),
							array('deny','users' => array('*')),
						);
		}
	
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
		
		public function filters()
		{
			return array('accessControl');
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
			
	
	        // Uncomment the following line if AJAX validation is needed
	        $this->performAjaxValidation($model, $this->formId);
	
	        if(isset($_POST['Publisher']))
	        {
	            $model->attributes = $_POST['Publisher'];
	            if($model->save())
	                $this->redirect(array('index'));
	        }
	
	        $this->render('update', array('model' => $model, 'formId' => $this->formId));
	    }	
		
		public function actiondeletePublisher($id)
		{
	        if(Yii::app()->request->isPostRequest)
	        {
				try
				{
		            if ($this->loadPublisherModel($id)->delete())
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
					Yii::app()->user->setFlash($type, $msg);		
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
				}
				else
				{
					if (strcasecmp($type, "message") == 0)
						echo "<div class='msg msg-ok push-1 span-21  prepend-top'><p><strong>".$msg."</strong></p></div>";
					elseif (strcasecmp($type, "error") == 0)
						echo "<div class='msg msg-error push-1 span-21  prepend-top'><p><strong>".$msg."</strong></p></div>";
				}
	        }
	        else
	            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
		
	    public function loadPublisherModel($id)
	    {
	        $model = Publisher::model()->findByPk($id);
	        if($model === null)
	            throw new CHttpException(404, "Couldn't complete the operation");
	        return $model;
	    }
		
	}
?>