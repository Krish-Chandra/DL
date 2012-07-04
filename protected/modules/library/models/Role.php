<?php

class Role extends CActiveRecord
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
		return 'role';
	}

	public static function getUserRole($Id)
	{
		$module = Yii::app()->controller->module->name;
		if (strcasecmp($module, "admin") == 0)
		{
			$sql = "SELECT rolename FROM role r, admin_user au WHERE au.id = {$Id} AND au.role_id = r.id";
			$results = self::model()->findBySql($sql);
			return $results["rolename"];
		}
		else
			return "members";
			
	}
	

}