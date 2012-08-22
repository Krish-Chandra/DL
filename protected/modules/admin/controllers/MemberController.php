<?php
	class MemberController extends Controller
	{
		public $formId = 'members-form';
	
		public function actionIndex()
		{
	        $dataProvider = Member::model()->getAllMembers();
			$members = $dataProvider->data;

			if (empty($members))
			{
				Yii::app()->user->setFlash('error', "No Member in the system!");	
			}
			
	        $this->render('index', array('dataProvider' => $dataProvider,));
				
		}
		

	    public function actionupdateMember($id)
	    {
	        $member = $this->loadMemberModel($id);
			if ($member === null)
			{
				Yii::app()->cache->flush();				
				$msg = "Couldn't complete the operation as the member is not found!";
				Yii::app()->user->setFlash('error', $msg);	
				$this->redirect(array('index'));
			}
			else
			{
			    // Uncomment the following line if AJAX validation is needed
		        $this->performAjaxValidation($member, $this->formId);
		
		        if(isset($_POST['Member']))
		        {
					$member->active = $_POST['Member']['active'];
		            if($member->save())
					{
						Yii::app()->user->setFlash('message', "Successfully updated the member's details!");
						$this->redirect(array('index'));
					}
					else
					{
						Yii::app()->user->setFlash('error', "Couldn't update the member's details!!");	
					}
		                
		        }
		
		        $this->render('update', array('model' => $member, 'formId' => $this->formId));
			}
	    }	
		
	    public function loadMemberModel($id)
	    {
	        $model = Member::model()->findByPk($id);
/*	        if(($model === null) || empty($model))
	            throw new CHttpException(404, "Couldn't complete the operation");*/
	        return $model;
	    }
		
		public function actiondeleteMember($id)
		{
	        if(Yii::app()->request->isPostRequest)
	        {
				$model = $this->loadMemberModel($id);				
				if ($model === null)
				{
					Yii::app()->cache->flush();				
					$msg = "Couldn't complete the operation as the member is not found!";
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
							$msg = "Successfully deleted the Member!";	
		
						}
						else
						{
							$type = "error";
							$msg =  "Couldn't delete the Member!";	
						}
					}
					catch (CDbException $ex)
					{
						$type = "error";
						$msg = "Couldn't delete the Memeber! Check if any book has been issued to her/him!!";					
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