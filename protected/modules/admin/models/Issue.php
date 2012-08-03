<?php

/**
 * This is the model class for table "issue".
 *
 */
class Issue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Issues the static model class
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
		return 'issue';
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
			array('issue_date, due_date', 'required'),
//			array('user_id', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('issue_date', 'safe', 'on' => 'search'),
		);
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
			'user' => array(self::BELONGS_TO, 'Member', 'user_id'),
			'book' => array(self::BELONGS_TO, 'Book', 'book_id'),
		);
	}

	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('issue_date', $this->issue_date, true);

		return new CActiveDataProvider($this, array('criteria' => $criteria,));
	}
	
	public function getAllIssues()
	{
		$dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM issue');	
		$dataProvider =  new CActiveDataProvider(self::model()->cache(Yii::app()->params['cacheDuration'], $dependency, 2), array('pagination' => array ('pageSize' => 50)));		
		return $dataProvider;
	}	
	
}