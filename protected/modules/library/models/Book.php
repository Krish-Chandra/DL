<?php

/**
 * This is the model class for table "book".
 */
class Book extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Books the static model class
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

/*
	public function checkAvailableCopies($attribute, $params)
	{
		if( $this->total_copies < $this->available_copies) //Available copies can't be greater than Total copies of the book'			
			$this->addError($attribute, "Available Copies of the Book can't be more than the Total Copies!");
	}

*/	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array
		(
			'categories'=> array(self::MANY_MANY, 'Category', 'book_category(book_id, category_id)', 'together' => true),
			'authors'	=> array(self::MANY_MANY, 'Author', 'book_author(book_id, author_id)', 'together' => true),
			'publisher' => array(self::BELONGS_TO, 'Publisher', 'publisher_id', 'together' => true),
		);
	}

	
	public function getAllBooks()
	{
		$dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM book');
		$dataProvider =  new CActiveDataProvider(self::model()->cache(Yii::app()->params['cacheDuration'], $dependency, 6), array('pagination' => array ('pageSize' => 50)));	
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
			$dependency = new CExpressionDependency("sizeof(Yii::app()->session['reqCart'])");				
			$dataProvider = new CActiveDataProvider(self::model()->cache(Yii::app()->params['cacheDuration'], $dependency, 4), array('criteria' => $criteria));
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
}