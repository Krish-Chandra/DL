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

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array
		(
			'users' => array(self::HAS_MANY, 'user', 'role_id'),
		);
	}

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array
		(
			array('rolename', 'required'),
            array('rolename', 'length', 'max' => 50),
			array('rolename', 'unique', 'message' => "The entered Role has already been added!"),
			array('description', 'required'),
            array('description', 'length', 'max' => 100),			
            array('rolename', 'safe', 'on' => 'search'),
        );
    }

	public function attributeLabels()
	{
		return array
		(
			'rolename' => 'Role Name',
			'description'=>'Description',
		);
	}
	
	

	public static function getUserRole($Id)
	{
		$module = Yii::app()->controller->module->name;
		if (strcasecmp($module, "Admin") == 0)
		{
			$sql = "SELECT rolename FROM role r, admin_user au WHERE au.id = {$Id} AND au.role_id = r.id";
			$results = self::model()->findBySql($sql);
			return $results["rolename"];
		}
		else
			return "members";
			
	}
	
	public function getAllRoles()
	{
		$dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM role');	
		$dataProvider =  new CActiveDataProvider(self::model()->cache(Yii::app()->params['cacheDuration'], $dependency, 2), array('pagination' => array ('pageSize' => 50)));		
//		$dataProvider = new CActiveDataProvider('Role');
		return $dataProvider;
	}

	public function getRoleNameById($Id)
	{
		$result = self::model()->findByPk($Id);
		if ($result === NULL)
		{
			return NULL;
		}
		else
		{
			return $result->rolename;
		}
	}

	public function beforeSave()
	{
		$this->update_time = new CDbExpression('NOW()'); //date("Y-m-d H:i:s");				 
	    return parent::beforeSave();
	}	
}