<?php
	class AuthorController extends Controller
	{
		public $formId = 'authors-form';
		
		public function accessRules()
		{
	
			return array(
							array('allow','roles' => array('admin', 'supervisor')),
							array('deny','users' => array('*')),
						);
		}
	
		public function actionIndex()
		{
	        $dataProvider = Author::model()->getAllAuthors();
			$authors = $dataProvider->data;

			if (empty($authors))
			{
				$msg = "No Author has been added to the system!";
				Yii::app()->user->setFlash('error', $msg);	
			}
			
	        $this->render('index', array('dataProvider'=>$dataProvider));
		}
	
	
	    public function actionCreateAuthor()
	    {
	        $model = new Author;
	
	        $this->performAjaxValidation($model, $this->formId);
	
	        if(isset($_POST['Author']))
	        {
	            $model->attributes = $_POST['Author'];
	            if($model->save())
	                $this->redirect('index');
	        }
	
	        $this->render('create', array('model' => $model, 'formId' => $this->formId ));
	    }	

		public function actionUpdateAuthor($id)
		{
			$model = $this->loadAuthorModel($id);
			if ($model === null)
			{
				Yii::app()->cache->flush();				
				$msg = "Couldn't complete the operation as the author is not found!";
				Yii::app()->user->setFlash('error', $msg);	
				$this->redirect(array('index'));
			}
			else
			{
				$this->performAjaxValidation($model, $this->formId);
			    if(isset($_POST['Author']))
			    {
			        $model->attributes=$_POST['Author'];
					//$model->update_time = date("Y-m-d H:i:s");				
			        if($model->save())
			            $this->redirect(array('index'));
			    }
			
			    $this->render('update', array('model' => $model, 'formId' => $this->formId));
			}			
		}	
	
		public function actionDeleteAuthor($id)
		{
		    if(Yii::app()->request->isPostRequest)
		    {
				$model = $this->loadAuthorModel($id);
				if ($model === null)
				{
					Yii::app()->cache->flush();				
					$msg = "Couldn't complete the operation as the author is not found!";
					echo "<div class='msg msg-error push-1 span-21  prepend-top'><p><strong>".$msg."</strong></p></div>";					
				}
				else
				{
					try
					{
				        if ($model->delete())
						{
							$type = "message";
							$msg = "Successfully deleted the Author!";	
						}
						else
						{
							$type = "error";
							$msg =  "Couldn't delete the Author!";	
						}
					}
					catch(CDbException $ex)
					{
						$type = "error";
						$msg = "Couldn't delete the Author! Please check if a book authored by this Author has been issued to a Member and try again!!";
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
	
		public function loadAuthorModel($id)
		{
		    $model = Author::model()->findByPk($id);
/*		    if($model === null)
		        throw new CHttpException(404, "Couldn't complete the operation");*/
		    return $model;
		}

		public function getAllAuthors()
		{
		    $model = Author::model()->findAll();
		    if($model === null)
		        throw new CHttpException(404, "Couldn't complete the operation");
		    return $model;
			
		}	
	
		public function filters()
		{
			return array('accessControl');
		}

/*		public function actionError()
		{
		    if($error = Yii::app()->errorHandler->error)
		    {
		    	if(Yii::app()->request->isAjaxRequest)
		    		echo $error['message'];
		    	else
		        	$this->render('error', $error);
		    }
		}*/
	}

?>