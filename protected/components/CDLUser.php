<?php

class CDLUser extends CWebUser
{
	public function init()
	{
		parent::init();
		$app = Yii::app();
		$ctrl = $app->controller;
		if ((strcasecmp(Yii::app()->controller->module->name, "admin") == 0) || (strcasecmp(Yii::app()->controller->module->name, "srbac") == 0))
		{
			$this->loginUrl = Yii::app()->createUrl("admin/default/login");
		}
		else
		{
			$this->loginUrl = Yii::app()->createUrl("library/default/login");
		}
	}

}

