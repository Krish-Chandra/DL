<?php
	class BookController extends Controller
	{
		public $formId = 'books-form';
		public function accessRules()
		{
	
			return array(
							array('allow', 'roles' => array('admin', 'supervisor', 'Assistant Librarian')),
							array('deny', 'users' => array('*')),
						);
		}
	
		public function actionIndex()
		{
			//Before adding a book, atleast one Publisher, Category and Author should hae been added
			if (!$this->getAllPublishers() || !$this->getAllCategories() || !$this->getAllAuthors() )
				$canAddNewBook = false;
			else
				$canAddNewBook = true;				
				
	        $dataProvider = Book::model()->getAllBooks();
			$books = $dataProvider->data;

			if (empty($books))
			{
				$msg = "No Book has been added to the system!";
				$msg .= !$canAddNewBook ? " Please add atleast one Author, Category, and Publisher before adding a book!!" :  "";
				Yii::app()->user->setFlash('error', $msg);	
			}
			
	        $this->render('index', array('dataProvider' => $dataProvider, 'canAddNewBook' => $canAddNewBook));
				
		}
		
		public function filters()
		{
			return array('accessControl');
		}
		
	    public function actionCreateBook()
	    {
	        $model = new Book();
	
			$publishers	= $this->getAllPublishers();
			$categories = $this->getAllCategories();
			$authors	= $this->getAllAuthors();
			
			if (!$publishers || !$categories || !$authors )
	            throw new CHttpException(404, "Couldn't add a Book now! Please add atleast one Author, Publisher, and Category first!!");			
			else
			{
				
				foreach($publishers as $pub)
				{
					$pubarray[$pub->id] = $pub->publishername;
				}
		
				foreach($categories as $cat)
				{
					$catarray[$cat->id] = $cat->categoryname;
				}
		
				foreach($authors as $auth)
				{
					$autharray[$auth->id] = $auth->authorname;
				}
		
		        // Uncomment the following line if AJAX validation is needed
		        $this->performAjaxValidation($model, $this->formId);
		
		        if(isset($_POST['Book']))
		        {
		            $model->attributes = $_POST['Book'];
		            if($model->save())
		                $this->redirect(array('index'));
		        }
		
		        $this->render('create', array('model' => $model, 'publishers' => $pubarray, 'categories' => $catarray, 'authors' => $autharray, 'formId' => $this->formId ));
			}
		}	
		
	    public function actionUpdateBook($id)
	    {
	        $model = $this->loadBookModel($id);
			if ($model === null)
			{
				throw new CHttpException(404, "Couldn't find the Book!");		
			}
			$publishers	= $this->getAllPublishers();
			$categories = $this->getAllCategories();
			$authors	= $this->getAllAuthors();

			if (!$publishers || !$categories || !$authors )
	            throw new CHttpException(404, "Couldn't update the Book now! Please add atleast one Author, Publisher, and Category first!!");			
			else
			{
			
				foreach($publishers as $pub)
				{
					$pubarray[$pub->id] = $pub->publishername;
				}
		
				foreach($categories as $cat)
				{
					$catarray[$cat->id] = $cat->categoryname;
				}
		
				foreach($authors as $auth)
				{
					$autharray[$auth->id] = $auth->authorname;
				}
		
		        $this->performAjaxValidation($model, $this->formId);
		
		        if(isset($_POST['Book']))
		        {
		            $model->attributes = $_POST['Book'];
		            if($model->save())
		                $this->redirect(array('index'));
		        }
		
		        $this->render('update', array('model' => $model, 'publishers' => $pubarray, 'categories' => $catarray, 'authors' => $autharray, 'formId' => $this->formId  ));
			}
	    }	
		
		public function actiondeleteBook($id)
		{
	        if(Yii::app()->request->isPostRequest)
	        {
				$model = $this->loadBookModel($id);
				if ($model === null)
				{
					throw new CHttpException(404, "Couldn't find the Book!");		
				}
				else
				{
					try
					{
			            if ($model->delete())
						{
							$type = "message";
							$msg = "Successfully deleted the Book!";	
						}
						else
						{
							$type = "error";
							$msg =  "Couldn't delete the Book!";	
						}
					}
					catch (CDbException $ex)
					{
						$type = "error";
				        $msg = "Couldn't delete the Book! Please check if it has been issued to a Member and try again!!";
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
	        }
	        else
	            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
		
	    public function loadBookModel($id)
	    {
	        $model = Book::model()->findByPk($id);
/*	        if($model === null)
	            throw new CHttpException(404, 'The requested page does not exist.');*/
	        return $model;
	    }
		
		public function getAllPublishers()
		{
	        $model = Publisher::model()->findAll();
			if($model === null)
	            throw new CHttpException(404, "Couldn't complete the operation!");
	        return $model;
			
		}	
		
		public function getAllAuthors()
		{
	        $model = Author::model()->findAll();
	        if($model === null)
	            throw new CHttpException(404, "Couldn't complete the operation!");
	        return $model;
			
		}	
		
		public function getAllCategories()
		{
	        $model = Category::model()->findAll();
	        if($model === null)
	            throw new CHttpException(404, "Couldn't complete the operation!");
	        return $model;
		}	
	}
?>