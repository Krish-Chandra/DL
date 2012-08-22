<?php
	class CategoryController extends Controller
	{
		public $formId = 'categories-form';
		
		public function actionIndex()
		{
	        $dataProvider = Category::model()->getAllCategories();
			$categories = $dataProvider->data;

			if (empty($categories))
			{
				$msg = "No Category has been added to the system!";
				Yii::app()->user->setFlash('error', $msg);	
			}
			
	        $this->render('admin.views.category.index', array('dataProvider' => $dataProvider));
		}
		
	    public function actionCreateCategory()
	    {
	        $model = new Category;
	
	        // Uncomment the following line if AJAX validation is needed
	        $this->performAjaxValidation($model, $this->formId);
	
	        if(isset($_POST['Category']))
	        {
	            $model->attributes = $_POST['Category'];
	            if($model->save())
	                $this->redirect(array('index'));
	        }
	
	        $this->render('create', array('model' => $model, 'formId' => $this->formId));
	    }	
	
		public function actionUpdateCategory($id)
		{
		    $model = $this->loadCategoryModel($id);
			if ($model === null)
			{
				Yii::app()->cache->flush();				
				$msg = "Couldn't complete the operation as the category is not found!";
				Yii::app()->user->setFlash('error', $msg);	
				$this->redirect(array('index'));
			}
			else
			{
			    $this->performAjaxValidation($model, $this->formId);
			
			    if(isset($_POST['Category']))
			    {
			        $model->attributes = $_POST['Category'];
					//$model->update_time = date("Y-m-d H:i:s");				
			        if($model->save())
			            $this->redirect(array('index'));
			    }
			
			    $this->render('update', array('model' => $model, 'formId' => $this->formId));
			}
		}	
		
		public function actiondeleteCategory($id)
		{
		    if(Yii::app()->request->isPostRequest)
		    {
			    $model = $this->loadCategoryModel($id);
				if ($model === null)
				{
					Yii::app()->cache->flush();				
					$msg = "Couldn't complete the operation as the category is not found!";
					echo "<div class='msg msg-error push-1 span-21  prepend-top'><p><strong>".$msg."</strong></p></div>";					
				}
				else
				{
					try
					{
					
			            if ($model->delete())
						{
							$type = "message";
							$msg = "Successfully deleted the Category!";	
			
						}
						else
						{
							$type = "error";
							$msg =  "Couldn't delete the Category!";	
						}
					}		
					catch (CDbException $ex)			
					{
						$type = "error";
						$msg = "Couldn't delete the Category! Please Check if a book belonging to this Category has been issued to a Member and try again!!";									
		
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
		
		public function loadCategoryModel($id)
		{
		    $model = Category::model()->findByPk($id);
/*		    if($model === null)
		        throw new CHttpException(404, "Couldn't complete the operation");*/
		    return $model;
		}
		
		public function getAllCategories()
		{
		    $model = Category::model()->findAll();
		    if($model === null)
		        throw new CHttpException(404, "Couldn't complete the operation");
		    return $model;
			
		}	
		
	}
?>