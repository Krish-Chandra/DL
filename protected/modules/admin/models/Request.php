<?php

/**
 * This is the model class for table "request".
 *
 */
class Request extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Requests the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'request';
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
			'book' => array(self::BELONGS_TO, 'Book', 'book_id'),
			'user' => array(self::BELONGS_TO, 'Member', 'user_id'),
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

		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('book_id', $this->book_id, true);
		$criteria->compare('date', $this->date, true);

		return new CActiveDataProvider($this, array('criteria' => $criteria,));
	}
	
	public function getAllRequests()
	{
		$dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM request');
		$dataProvider =  new CActiveDataProvider(self::model()->cache(Yii::app()->params['cacheDuration'], $dependency, 2), array('pagination' => array ('pageSize' => 50)));	
		return $dataProvider;
	}

/*		
	public function addRequest($bookId)
	{
		$Req = new Requests;
		$Req->Date = date("y/m/d");
		$Req->user_id = Yii::app()->user->id;
		$Req->book_id = $bookId;
		return $Req->save();
	}
*/	
	public function beforeSave()
	{
		$this->update_time = new CDbExpression('NOW()'); //date("Y-m-d H:i:s");				 
	    return parent::beforeSave();
	}	
}