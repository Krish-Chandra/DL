<?php

class CLibraryUserIdentity extends CUserIdentity
{
	private $_id;
	const ERROR_INACTIVE_USER = 999;	
	 
	private function hashUserPassword($pwd)
	{
	   if (empty($pwd))
	   {
		return FALSE;
	   }

		$str = sha1($pwd.Yii::app()->params['salt']);		
		return $str;
	}
	
	public function authenticate()
	{
	
		$user = LoginForm::model()->findByAttributes(array('username' => $this->username));
		if($user === null)
		{
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		else
		{
			$hashedPwd = $this->hashUserPassword($this->password);	
			if ($user->password !== $hashedPwd)
			{
				$this->errorCode = self::ERROR_USERNAME_INVALID;
			}
			elseif ($user->active == FALSE)
			{
				$this->errorCode = self::ERROR_INACTIVE_USER;
			}
			else
			{
				$this->errorCode=self::ERROR_NONE;
				$this->_id = $user->id;

			}
		}
		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->_id;
		
	}
}

?>