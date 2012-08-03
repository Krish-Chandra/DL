<?php
	class RoleController extends Controller
	{
		public $formId = 'roles-form';
		
		public function accessRules()
		{
			return array(
							array('allow', 'roles' => array('admin')),
							array('deny', 'users' => array('*')),
						);
		}
	
		public function actionIndex()
		{
	        $dataProvider = Role::model()->getAllRoles();
			$books = $dataProvider->data;

			if (empty($books))
			{
				$msg = "No Role has been added to the system!";
				Yii::app()->user->setFlash('error', $msg);	
			}
			
	        $this->render('index', array('dataProvider' => $dataProvider));
		}
	
		public function filters()
		{
			return array('accessControl');
		}

		public function loadRoleModel($id)
		{
		    $model = Role::model()->findByPk($id);
//		    if($model === null)
//		        throw new CHttpException(404, "Couldn't complete the operation");
		    return $model;
		}

	    public function actionUpdateRole($id)
	    {
	        $model = $this->loadRoleModel($id);
			if ($model === null)
			{
				Yii::app()->cache->flush();				
				$msg = "Couldn't complete the operation as the role is not found!";
				Yii::app()->user->setFlash('error', $msg);	
				$this->redirect(array('index'));
			}
			else
			{
		        // Uncomment the following line if AJAX validation is needed
		        $this->performAjaxValidation($model, $this->formId);
		
		        if(isset($_POST['Role']))
		        {
		            $model->attributes = $_POST['Role'];
					//$model->update_time = date("Y-m-d H:i:s");				
		            if($model->save())
					{
						Yii::app()->user->setFlash('message', "Successfully updated the role's details!");
		                $this->redirect(array('index'));
					}
		        }
			}	
	        $this->render('update', array('model' => $model, 'formId' => $this->formId));
	    }
		
		
	    public function actionCreateRole()
	    {
	        $model = new Role;
	
	        // Uncomment the following line if AJAX validation is needed
	        $this->performAjaxValidation($model, $this->formId);
	
	        if(isset($_POST['Role']))
	        {
	            $model->attributes = $_POST['Role'];
	            if($model->save())
				{
					Yii::app()->user->setFlash('message', "Successfully created the role!");
	                $this->redirect(array('index'));
				}

	        }
	
	        $this->render('create', array('model' => $model, 'formId' => $this->formId));
	    }	
		
		public function actiondeleteRole($id)
		{
		    if(Yii::app()->request->isPostRequest)
		    {
				$model = $this->loadRoleModel($id);				
				if ($model === null)
				{
					Yii::app()->cache->flush();				
					$msg = "Couldn't complete the operation as the role is not found!";
					echo "<div class='msg msg-error push-1 span-21  prepend-top'><p><strong>".$msg."</strong></p></div>";					
				}
				else
				{
					try
					{
				        // we only allow deletion via POST request
				        if ($model->delete())
						{
							$type = "message";
							$msg = "Successfully deleted the Role!";	
			
						}
						else
						{
							$type = "error";
							$msg =  "Couldn't delete the Role!";	
						}
						
					}
					catch (CDbException $ex)
					{
						$type = "error";
						$msg = "Couldn't delete the Role! Please try again!!";
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
	}
?>