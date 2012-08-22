<?php

/**
 * This is the model class for table "user".
 * The srbac module needs to know about the User class to get all the admin users defined in the system
 * Hence, we have a stripped down version of the class in this folder
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

}