<?php

/**
 * This is the model class for table "book".
 */
class Book extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Book the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'book';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array
		(
            array('title', 'required'),	
//            array('category_id', 'required'),				
//            array('author_id', 'required'),				
            array('publisher_id', 'required'),				
            array('total_copies', 'required'),				            
			array('available_copies', 'required'),							
			array('title', 'unique', 'message' => 'The entered Book has already been added!'),
			array('title', 'length', 'max'=>100),
			array('isbn', 'required'),
			//Regex pattern for isbn is by Darren Neimke, taken from www.regexlib.com
			array('isbn', 'match', 'pattern' => '/^ISBN\s(?=[-0-9xX ]{13}$)(?:[0-9]+[- ]){3}[0-9]*[xX0-9]$/'),
//			array('isbn', 'length', 'min' => '10', 'max'=>'13'),
			array('total_copies', 'numerical', 'min' => 1, 'max' => 200),
			array('total_copies', 'numerical', 'min'=>1),			
			//Use custom validator to check if AvailableCopies
			array('available_copies', 'checkAvailableCopies'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('title', 'safe', 'on'=>'search'),
		);
	}

	public function checkAvailableCopies($attribute, $params)
	{
		if( $this->total_copies < $this->available_copies) //Available copies can't be greater than Total copies of the book'			
			$this->addError($attribute, "Available Copies of the Book can't be more than the Total Copies!");
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array
		(
			'categories'	=> array(self::MANY_MANY, 'Category', 'book_category(book_id, category_id)', 'together' => true),
			'authors'	=> array(self::MANY_MANY, 'Author', 'book_author(book_id, author_id)', 'together' => true),
			'publisher' => array(self::BELONGS_TO, 'Publisher', 'publisher_id', 'together' => true),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array
		(
			'title'				=> 'Title',
//			'category_id'		=> 'Category',
//			'author_id'			=> 'Author',
			'publisher_id'		=> 'Publisher',
			'isbn'				=> 'ISBN',
			'total_copies'		=> 'Total Copies',
			'available_copies'	=> 'Available Copies',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('title', $this->Title, true);
		$criteria->compare('publisher_id', $this->publisher_id, true);
		$criteria->compare('isbn', $this->isbn, true);

		return new CActiveDataProvider($this, array('criteria' => $criteria));
	}
	
	public function getAllBooks()
	{
		$dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM book');
		$dataProvider =  new CActiveDataProvider(self::model()->cache(Yii::app()->params['cacheDuration'], $dependency, 7), array('pagination' => array ('pageSize' => 50)));	
		return $dataProvider;
	}
	
	public function getRequestedBooks()
	{
		$criteria = new CDbCriteria();
		$bookIds = Yii::app()->session['reqCart'];
		$Ids = array();
		if ($bookIds != NULL)
		{
			foreach($bookIds as $key => $val)
			{
				$Ids[] = $val;
			}
			$criteria->addInCondition('t.id', $Ids);
			//$criteria->with = array('authors', 'categories', 'publisher');
			$dataProvider = new CActiveDataProvider($this, array('criteria' => $criteria));
			return $dataProvider;
		}
		else
		{
			return NULL;			
		}

	}
	
	public function getBookNameById($Id)
	{
		$result = self::model()->findByPk($Id);
		if ($result === NULL)
		{
			return NULL;
		}
		else
		{
			return $result->title;
		}
	}
	public function beforeSave()
	{
		$this->update_time = new CDbExpression('NOW()'); //date("Y-m-d H:i:s");				 
	    return parent::beforeSave();
	}	
	public function behaviors()
	{
          return array( 'CAdvancedArBehavior' => array(
         	 'class' => 'application.extensions.CAdvancedArBehavior')); 
 	}	
	public function searchBooks($searchBy, $searchText)
	{
		$criteria = new CDbCriteria;
		if (strcasecmp($searchBy, "Title") == 0)
		{
			$criteria->condition = 'title like :title';
			$criteria->params = array(':title' => "%$searchText%");
			return new CActiveDataProvider($this, array('criteria' => $criteria));
		}
		else
		{
			$criteria->with = array('authors' => 
										array(
												'joinType' => 'INNER JOIN',
									            'condition'=> 'authorname LIKE :name',
												'params' => array(':name' => "%$searchText%")
											)
									);
			return new CActiveDataProvider($this, array('criteria' => $criteria, 'pagination' => array('pageSize' => 25)));
		}
	}
} 	
