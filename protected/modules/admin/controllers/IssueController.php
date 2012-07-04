<?php
	class IssueController extends Controller
	{
		public function accessRules()
		{
	
			return array(
							array('allow', 'roles' => array('admin')),
							array('deny', 'users' => array('*')),
						);
		}
		
		public function filters()
		{
			return array('accessControl');
		}
	
		public function actionIndex()
		{
	        $dataProvider = Issue::model()->getAllIssues();
			$issues = $dataProvider->data;

			if (empty($issues))
			{
				Yii::app()->user->setFlash('error', "No book has been issued to users!");	
			}
	        $this->render('index', array('dataProvider' => $dataProvider));
			
		}
		
		public function actionreturnBook($UserId, $BookId)		
		{
		    if(Yii::app()->request->isPostRequest)
		    {
				$adminModel = new AdminModel;
				if ($adminModel === NULL)
				{
					$type = "message";
					$msg = "Couldn't complete the operation! Please try again!!";		
				}
				else
				{
			        $retVal = $adminModel->returnBook($BookId, $UserId);
					if ($retVal)
					{
						$type = "message";
						$msg = "The operation completed successfully!!";		
	
					}
					else
					{
						$type = "message";
						$msg = "Couldn't complete the Operation! Please try again!!";
					}
				}
	
	            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
	            if(!isset($_GET['ajax']))
				{
					Yii::app()->user->setFlash($type, $msg);		
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
				}
				else
			        echo "<div class='msg msg-ok push-1 span-21  prepend-top'><p><strong>".$msg."</strong></p></div>";									
		    }
		    else
		        throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
		
		
	}
?>