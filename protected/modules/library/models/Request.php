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

	public function addRequest($bookId)
	{
		$this->date = date("y/m/d");
		$this->user_id = Yii::app()->user->id;
		$this->book_id = $bookId;
		return $this->save();
	}
}