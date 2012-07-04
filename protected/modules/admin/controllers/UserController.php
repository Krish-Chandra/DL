<?php
	class UserController extends Controller
	{
		public $formId = 'user-form';
		public function accessRules()
		{
			return array(
							array('allow', 'roles' => array('admin')),
							array('deny', 'users' => array('*')),
						);
		}
	
		public function actionIndex()
		{
	        $dataProvider = User::model()->getAllUsers();
			$users = $dataProvider->data;

			if (empty($users))
			{
				$msg = "No User has been added to the system! First add an 'admin' role and then add a user to this role. Users belonging to this role have full rights to the system!!";
				Yii::app()->user->setFlash('error', $msg);	
			}
			
	        $this->render('index', array('dataProvider' => $dataProvider,));
				
		}
		
		public function filters()
		{
			return array('accessControl');
		}

	    public function actionCreateUser()
	    {
			$this->createOrUpdate();
		}	

		private function createOrUpdate($id = null,  $isCreate = TRUE)		
		{
			if ($id == null)
		        $model = new User();
			else
				$model = $this->loadUserModel($id);			
	
			$roles = $this->getAllRoles();
			
			foreach($roles as $role)
			{
				$rolearray[$role->id] = $role->rolename;
			}
	
	        // Uncomment the following line if AJAX validation is needed
	        $this->performAjaxValidation($model, $this->formId);
	
	        if(isset($_POST['User']))
	        {
	            $model->attributes = $_POST['User'];
				try
				{
		            if($model->save())
					{
						if ($isCreate)
							Yii::app()->user->setFlash('message', "Successfully added the new User!");
						else
							Yii::app()->user->setFlash('message', "Successfully updated User details!");
							
						$this->redirect(array('index'));
						
					}
					else
					{
						$_POST['User']['password'] = "";
						$model->password = "";
					}
						
				
				}
				catch (Exception $e)
				{
					if ($isCreate)
						Yii::app()->user->setFlash('error', "Couldn't add the User! Contact the Administrator!!");
					else
						Yii::app()->user->setFlash('error', "Couldn't update the User's details!");
				}
	                
	        }
			if ($isCreate)	
	        	$this->render('create', array('model' => $model, 'roles' => $rolearray, 'formId' => $this->formId));
			else					
				$this->render('update', array('model'=>$model, 'roles' => $rolearray, 'formId' => $this->formId));
		}

	    public function actionupdateUser($id)
	    {
	        
	        if(isset($_POST['User']))
			{
				$roleId = $_POST['User']['role_id'];
				$isActive = $_POST['User']['active'];
				$user = $this->loadUserModel($id);							
				$user->role_id = $roleId;
				$user->active = $isActive;
				
				if ($user->save())
					Yii::app()->user->setFlash('message', "Successfully updated the User details!");
				else
					Yii::app()->user->setFlash('message', "Couldn't update the User details!");				
				$this->redirect(array('index'));
			}	
			else
				$this->createOrUpdate($id, FALSE);			
	        
	    }	

		
		public function actionusersInRole($id)		
		{
			$dataProvider = User::model()->usersInRole($id);
	        $this->render('index', array('dataProvider' => $dataProvider,));
			
		}
	    public function loadUserModel($id)
	    {
	        $model = User::model()->findByPk($id);
	        if(($model === null) || empty($model))
	            throw new CHttpException(404, "Couldn't complete the operation!");
	        return $model;
	    }
		
		public function getAllRoles()
		{
	        $model = Role::model()->getAllRoles();
	        if($model === null)
	            throw new CHttpException(404, "Couldn't complete the operation!");
	        return $model->data;
		}	
		
		public function actiondeleteUser($id)
		{
			// we only allow deletion via POST request
	        if(Yii::app()->request->isPostRequest)
	        {
				if (Yii::app()->user->id == $id) //The logged in user can't delete himself/herself
				{
					$msg = "Couldn't delete the User! You can't delete yourself!!";
				}
	            else
				{
					try
					{
			            if ($this->loadUserModel($id)->delete())
						{
							$type = "message";
							$msg = "Successfully deleted the User!";	
						}
						else
						{
							$type = "error";
							$msg =  "Couldn't delete the User! Please try again!!";	
						}
					}
					catch (CDbException $ex)
					{
						$type = "error";
						$msg = "Couldn't delete the User! Please try again!!";					
					}
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
		
	}
?>