<?php

/**
 * This is the model class for table "user".
 *
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'admin_user';
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
			array('username, password, email_id, role_id', 'required'),
			array('username', 'unique', 'message' => 'The entered User has already been added!'),
			array('username', 'length', 'max' => 100),
			array('active', 'boolean')
		); 
	}


	protected function afterValidate()
	{
		//set the following fields if and only if the record(user) is getting added 
		//Not when it's getting updated
		if (!isset($this->id) && $this->id == NULL)
		{
			$this->created_on = date("y/m/d");
			$this->password = $this->hashUserPassword();
		}
	}

	private function hashUserPassword($isPassword=true)
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
			'username' => 'User Name',
			'password' => 'Password',
			'email_id' => 'Email ID',
			'created_on' => 'Created On',
			'active' => 'Is active?',
			'role_id' =>'Role',
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
	public function GetAllUsers()
	{
		$dataProvider=new CActiveDataProvider('User');
		return $dataProvider;
	}
	public function displayUserName()
	{
		return $username;
	}
	
	public function usersInRole($id)
	{
		$dataProvider = new CActiveDataProvider('User', array('criteria' => array('condition' => "role_id={$id}")));		
		return $dataProvider;
	}
	
}