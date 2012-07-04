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
		return array
		(
			array('username, password', 'required'),
		); 
	}

	private function hashUserPassword($isPassword = true)
	{
		if ($isPassword)
		{
			$str = sha1($this->password.Yii::app()->params['salt']);	
		}
		else
		{
			$str = sha1($this->password_2.Yii::app()->params['salt']);
		}
		
		return $str;
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
			'role' => array(self::BELONGS_TO, 'Role', 'role_id'),
		); 
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array
		(
			'username' => 'Username',
			'password' => 'Password',
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

/*		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('activation_code',$this->activation_code,true);
		$criteria->compare('forgotten_password_code',$this->forgotten_password_code,true);
		$criteria->compare('remember_code',$this->remember_code,true);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('phone',$this->phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));*/
	}
}