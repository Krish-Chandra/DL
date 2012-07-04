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
			'category'	=> array(self::BELONGS_TO, 'Category', 'category_id'),
			'author'	=> array(self::BELONGS_TO, 'Author', 'author_id'),
			'publisher' => array(self::BELONGS_TO, 'Publisher', 'publisher_id'),
		);
	}


	
	public function getAllBooks()
	{
		$dataProvider = new CActiveDataProvider('Book');
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
			$criteria->with = array('author', 'category', 'publisher');
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
}