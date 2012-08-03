<?php

/**
 * This is the model class for table "user".
 *
 */
class Member extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(array('active', 'boolean')	); 
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array
		(
			'issues' => array(self::HAS_MANY, 'Issue', 'user_id'),
		); 
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array
		(
			'username' => 'Member Name',
			'active' => 'Is active?',			
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

	}
	
	public function getAllMembers()
	{
		$dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM user');
		$dataProvider =  new CActiveDataProvider(self::model()->cache(Yii::app()->params['cacheDuration'], $dependency, 2), array('pagination' => array ('pageSize' => 50)));	
		return $dataProvider;
	}
	
	public function deleteMember($id)
	{
		try
		{
			$member = $this->findByPk($id);
			if (isset($member) && !empty($member))
			{
				if ($member->delete())	
					return TRUE;
				else
					return FALSE;				
			}
			else
				return FALSE;

		}
		catch (Exception $e)
		{
			return FALSE;
		}
		
	}
	public function beforeSave()
	{
		$this->update_time = new CDbExpression('NOW()'); //date("Y-m-d H:i:s");				 
	    return parent::beforeSave();
	}	
}