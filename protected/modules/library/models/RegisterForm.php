<?php

class RegisterForm extends Member
{
	public $username;
	public $password;
	public $password_2;
	public $email;
    public $active = TRUE;
//	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	 
	public function rules()
	{
		$parentRules = parent::rules();
		return array_merge($parentRules, array(
			// username and password are required
			array('email_id', 'required'),
			array('username', 'unique'),
			array('password_2', 'compare', 'compareAttribute'=>'password'),
			array('email_id', 'email'),			
		));
	}

	public function attributeLabels()
	{
		$parentAttribLabels = parent::attributeLabels();
		return array_merge($parentAttribLabels, array(
			'password_2'=>'Confirm Password',
			'email_id'=>'Email ID',
		));
	}

	public function register()
	{
		try
		{
			$this->created_on = date("y/m/d");
			$this->password = $this->hashUserPassword();
			$this->password_2 = $this->hashUserPassword(false);		
			$this->active = TRUE;		
			if ($this->save())
				$retVal = true;			
			else
				$retVal = false;
		}
		catch (Exception $e)
		{
			
			$retVal = false;	
		}
			
		return $retVal;
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
	
}
