<?php

/**
 * This is the model class for table "publisher".
 *
 */
class Publisher extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Publishers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'publisher';
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
			array('publishername', 'required'),
			array('email_id', 'required'),			
			array('email_id', 'unique'),
			array('email_id', 'email'),			
			array('publishername', 'unique', 'message' => 'The entered Publisher has already been added!'),			
            array('publishername', 'length', 'max' => 75),
            array('address', 'length', 'max' => 100),
            array('city', 'length', 'max' => 30),
            array('state, phone', 'length', 'max' => 15),
            array('zip', 'length', 'max' => 10),


            array('email_id', 'length', 'max'=>50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('publishername', 'safe', 'on'=>'search'),
        );
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
			'books' => array(self::HAS_MANY, 'Book', 'publisher_id'),
		); 
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array
		(
            'publishername' => 'Publisher Name',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'email_id' => 'Email ID',
            'phone' => 'Phone',
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

        $criteria = new CDbCriteria;

        $criteria->compare('PublisherName', $this->publishername, true);

        return new CActiveDataProvider($this, array('criteria' => $criteria ));
    }
	
	public function getAllPublishers()
	{
		$dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM publisher');
		$dataProvider =  new CActiveDataProvider(self::model()->cache(Yii::app()->params['cacheDuration'], $dependency, 2), array('pagination' => array ('pageSize' => 50)));	
		return $dataProvider;
	}
	
	public function beforeSave()
	{
		$this->update_time = new CDbExpression('NOW()'); //date("Y-m-d H:i:s");				 
	    return parent::beforeSave();
	}	
}