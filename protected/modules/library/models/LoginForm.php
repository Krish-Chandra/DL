<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action
 */
class LoginForm extends Member
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
		$parentRules = parent::rules();
		return array_merge($parentRules, array(
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		));
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		$attribLabels = parent::attributeLabels();
		return array_merge($attribLabels, array('rememberMe' => 'Remember me'));
	}

	public function tableName()
	{
		return 'user';
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute, $params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity = new CLibraryUserIdentity($this->username, $this->password);				
			if(!$this->_identity->authenticate())
			{
				if ($this->_identity->errorCode == CLibraryUserIdentity::ERROR_INACTIVE_USER)
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
			$this->_identity = new CLibraryUserIdentity($this->username, $this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode === CLibraryUserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->allowAutoLogin = true;
			$retVal = Yii::app()->user->login($this->_identity, $duration);
			return true;
		}
		else
			return false;
	}
}
