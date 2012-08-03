<?php

/**
 * This is the model class for table "category".
 *
 */
class Category extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Categories the static model class
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
        return 'category';
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
			array('categoryname', 'required'),
			array('categoryname', 'unique', 'message' => 'The entered Category has already been added!'),
			array('categoryname', 'length', 'max'=> 75),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('categoryname', 'safe', 'on'=>'search'),
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
			'books' => array(self::MANY_MANY, 'Book', 'book_category(category_id, book_id)'),
		); 

    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array
		(
			'categoryname' => 'Category Name',
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

        $criteria->compare('categoryname', $this->categoryname, true);

        return new CActiveDataProvider($this, array('criteria' => $criteria ));
    }
	
	public function getAllCategories()
	{
		$dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM category');	
		$dataProvider =  new CActiveDataProvider(self::model()->cache(Yii::app()->params['cacheDuration'], $dependency, 2), array('pagination' => array ('pageSize' => 50)));		
		return $dataProvider;
	}
	
	public function beforeSave()
	{
		$this->update_time = new CDbExpression('NOW()'); //date("Y-m-d H:i:s");				 
	    return parent::beforeSave();
	}	
}