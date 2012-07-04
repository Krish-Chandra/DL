<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data.
 */
class LoginForm extends CActiveRecord
{
	public $username;
	public $password;
	public $rememberMe = TRUE;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array
		(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array
		(
			'rememberMe' => 'Remember me next time',
		);
	}

	public function tableName()
	{
		return 'admin_user';
	}

	public function authenticate($attribute, $params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity = new CAdminUserIdentity($this->username, $this->password);				
			if(!$this->_identity->authenticate())
			{
				if ($this->_identity->errorCode == CAdminUserIdentity::ERROR_INACTIVE_USER)
				{
					Yii::app()->user->setFlash('error', "The User is Inactive! Please contact the Administrator!!");					
				}
				else
				{
					Yii::app()->user->setFlash('error', "Invalid Username or Password!");					
				}
			}
				
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity === null)
		{
			$this->_identity = new CAdminUserIdentity($this->username, $this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode === CAdminUserIdentity::ERROR_NONE)
		{
			$duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->allowAutoLogin = true;
			$retVal = Yii::app()->user->login($this->_identity, $duration);
			return true;
		}
		else
			return false;
	}
}
