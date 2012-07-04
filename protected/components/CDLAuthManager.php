<?php
class CDLAuthManager extends CPhpAuthManager
{
    public function init()
	{
 
		parent::init();
 
		if(!Yii::app()->user->isGuest)
		{
			$role = Role::getUserRole(Yii::app()->user->id);
			$this->assign($role, Yii::app()->user->id);
		}
    }
}
?>