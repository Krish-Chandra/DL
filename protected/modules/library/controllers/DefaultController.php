<?php
class DefaultController extends CController
{

	public function accessRules()
    {
        return array
		(
            array
			(
				'deny', 'actions' => array('Checkout'), 'users'=>array('?'),
            ),
        );
    }
	
	public function actions()
	{
		return array
		(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array('class' => 'CCaptchaAction', 'backColor' => 0xFFFFFF),
		);
	}

	
	public function getActionParams()
	{
		return array_merge($_GET, $_POST);
	}
	
	public function actionIndex()
	{
		$model = Book::model();
		$dataProvider = $model->getAllBooks();
		$books = $dataProvider->data;

		if (empty($books))
		{
			$msg = "The Books catalog is empty!";
			Yii::app()->user->setFlash('error', $msg);	
		}
		
		$data = array('dataProvider' => $dataProvider);
		$this->render('index', $data);
	}

	public function actionaddToReqCart($bookId)
	{
		if ((Yii::app()->session['reqCart'] !== null) && isset(Yii::app()->session['reqCart']))
		{
			$reqCart = Yii::app()->session['reqCart'];
		}
		else
		{
			$reqCart = array();	
		}
		
		$index = array_search($bookId, $reqCart);					
		if ($index === FALSE) //Add the book to the cart if only it's not there already
		{
			$reqCart[] = $bookId;
		}
			
		Yii::app()->session['reqCart'] = $reqCart;
		Yii::app()->user->setFlash('message', "Selected books have been successfully added to the request cart!");		
		$this->redirect(array('index'));		
	}
	
	public function actionviewReqCart()
	{
		$model = Book::model();
		$reqBooks = $model->getRequestedBooks(); //Get all the books that have been added to the cart
		if (!empty($reqBooks->data))
		{
			$data = array('dataProvider' => $reqBooks);		
			$this->render('viewcart', $data);
		}
		else
		{
			Yii::app()->user->setFlash('error', "Your request cart is empty!");				
			$this->render('viewcart');
		}
	}	

	public function actioncheckout()
	{
		$reqCart = Yii::app()->session['reqCart'];
		$isError = false;
		if ($reqCart != NULL)
		{
			$message = "Couldn't process the request for the following book(s): <br />";
			for ($i = 0; $i < sizeof($reqCart); $i++)			
			{
				$bookId = $reqCart[$i];
				try
				{
					$bookName = Book::model()->getBookNameById($bookId);
					if ($bookName === null) //Unexpected: Book could have been deleted from the system after it's been added to the request cart
					{
						$isError = true;
						$message = "Couldn't process all your requests! Contact the Administrator!!";
						$this->removeBookFromRequestCart($bookId);						
					}
					else
					{
						$model = new Request;
						if (!$model->addRequest($bookId))
						{
							$message .= "{$bookName} <br/>";
							$isError = TRUE;
						}
						else	
						{
							//Request for the book is successfully processed. We need to remove the book ($bookId) from the cart
							$this->removeBookFromRequestCart($bookId);
						}
					}
				}
				catch (CDbException $ex)
				{
					$message .= "{$bookName} <br/>";
					$isError = TRUE;
				}
			}
			if (!$isError)
			{
				Yii::app()->session->clear();
				Yii::app()->user->setFlash('message', "All your requests have been successfully processed!");				
				$this->redirect(array('index'));		
			}
			else
			{
				Yii::app()->user->setFlash('error', $message);				
				$this->redirect(array('index'));		
			}
		}
		else
		{
			Yii::app()->user->setFlash('error', "Your request cart is empty!");
			$this->render('viewcart');
				
		}

	}	
	
	public function actionremoveFromReqCart($bookId)
	{
				
		if ($this->removeBookFromRequestCart($bookId))
			echo "<div class='msg msg-ok push-1 span-21  prepend-top'><p><strong>"."The selected book has been successfully removed from the request cart!"."</strong></p></div>";
		else
			echo "<div class='msg msg-ok push-1 span-21  prepend-top'><p><strong>"."Couldn't remove the book from the request cart! Please try again!!"."</strong></p></div>";

		//$this->redirect(array('viewReqCart'));		
	}

	private function removeBookFromRequestCart($bookId)	
	{
		$reqCart = Yii::app()->session['reqCart'];
		if (isset($reqCart) && ($reqCart !== NULL))
		{
			$index = array_search($bookId, $reqCart);					
			if ($index !== FALSE)
			{
				unset($reqCart[$index]);
				$reqCart = array_values($reqCart);
				Yii::app()->session['reqCart'] = $reqCart;				
				return TRUE;
			}
		}
		return FALE;
	}
	
	public function actionError()
	{
	    if($error = Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', array('error' => $error));
	    }
	}

	public function actionRegister()
	{
		$model = new RegisterForm;
	
		$this->performAjaxValidation($model, 'register-form');
	
		// collect user input data
		if(isset($_POST['RegisterForm']))
		{
			$model->attributes = $_POST['RegisterForm'];
			// validate user input and redirect to the previous page if valid
			try
			{
				if($model->validate() && $model->register())
				{
					Yii::app()->user->setFlash('message', "Registration succeeded!");	
					$this->redirect(Yii::app()->user->returnUrl);
//					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
				}
			}
			catch (Exception $ex)
			{
				Yii::app()->user->setFlash('error', "Registration failed! Contact the Librarian!!");
			}
				
		}
	
		$this->render('register',array('model'=>$model));
		
	}
	
	public function actionLogin()
	{
		$model = new LoginForm;

		$this->performAjaxValidation($model, 'login-form');
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
//				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		// display the login form
		$this->render('login', array('model' => $model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm;
		
		$this->performAjaxValidation($model, 'contact-form');

		if(isset($_POST['ContactForm']))
		{
			$model->attributes = $_POST['ContactForm'];
			if($model->validate())
			{
				$headers = "From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us! We will get back to you as soon as possible!!');
				$this->refresh();
			}
		}
		$this->render('contact', array('model' => $model));
	}
	
	public function actionSearch()
	{
/*		$cache = Yii::app()->cache;
		if (isset($_POST['sFilter']))
			$searchBy = $_POST['sFilter'];
			
		$searchBy = $_POST['sFilter'];
		$searchText = $_POST['sTitle'];
		if (isset($searchText) && !empty($searchText))
		{
			$model = Book::model();
			$dataProvider = $model->searchBooks($searchBy, $searchText);
	        $this->render('index', array('dataProvider' => $dataProvider));
		}
		else
			$this->redirect('index');
*/
		$cache = Yii::app()->cache;
		if (isset($_POST['sFilter']))
		{
			$searchBy = $_POST['sFilter'];
			$searchText = $_POST['sTitle'];
			$cache['sFilter'] = $searchBy;
			$cache['sTitle'] = $searchText;
		}
		else
		{
			$searchBy = $cache['sFilter'];
			$searchText = $cache['sTitle'];
		}
			
			
			
		if (isset($searchText) && !empty($searchText))
		{
			$model = Book::model();
			$dataProvider = $model->searchBooks($searchBy, $searchText);
	        $this->render('index', array('dataProvider' => $dataProvider));
		}
		else
			$this->render('index');
			
	}	
	
	public function filters()
    {
        return array('accessControl');
    }	
	
	protected function performAjaxValidation($model, $id)
	{
	    if(isset($_POST['ajax']) && $_POST['ajax'] === $id)
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	}

}
?>