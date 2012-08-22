<?php
	class RequestController extends Controller
	{
		
		public function actionIndex()
		{
	        $dataProvider = Request::model()->getAllRequests();
			$requests = $dataProvider->data;
			if ( empty($requests))
			{
				Yii::app()->user->setFlash('error', "There are no requests for Books!");		
			}
	        $this->render('index', array('dataProvider' => $dataProvider,));
				
		}
		public function actionissueBook($id, $bookId, $userId)	
		{
		    if(Yii::app()->request->isPostRequest)
		    {
				$adminModel = new AdminModel;
				if ($adminModel === NULL)
				{
					$type = "message";
					$msg = "Couldn't complete The operation! Please try again!!";		
				}
				else
				{
					try
					{
				        $retVal = $adminModel->issueBook($id, $bookId, $userId);
						if ($retVal)
						{
							$type = "message";
							$msg = "The book has been issued to the user!";		
		
						}
						else
						{
							$type = "message";
							$msg = "Couldn't issue the book to the user! Please try again!!";
						}
					}
					catch (CDebException $ex)
					{
						$msg = "Couldn't issue the book to the user! Please try again!!";	
					}
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
		    else
		        throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
				
		}
	}
?>