<?php

/**
 * This is the model class for table "author".
 *
 */
class Author extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Authors the static model class
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
        return 'author';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('authorname', 'required'),	
			array('authorname', 'unique', 'message' => 'The entered Author has already been added!'),
            array('authorname', 'length', 'max' => 50),
            array('address', 'length', 'max' => 100),
            array('email_id', 'required'),			
            array('city, email_id', 'length', 'max' => 25),
            array('email_id', 'email'),			
            array('state, zip', 'length', 'max' => 10),
			//Accepts only valid valid US states
			array('state', 'match', 'pattern' => '/^(?-i:A[LKSZRAEP]|C[AOT]|D[EC]|F[LM]|G[AU]|HI|I[ADLN]|K[SY]|LA|M[ADEHINOPST]|N[CDEHJMVY]|O[HKR]|P[ARW]|RI|S[CD]|T[NX]|UT|V[AIT]|W[AIVY])$/'),
            array('phone', 'length', 'min' => 10, 'max' => 14),
 			array('phone', 'match', 'pattern' => '/^\(?(\d{3})\)?-?(\d{3})-(\d{4})$/'), 		
			//Zip has to be in valid US format
			array('zip', 'match', 'pattern' => '/^\d{5}(-\d{4})?$/'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('authorname', 'safe', 'on' => 'search'),
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
			//'books' => array(self::HAS_MANY, 'Books', 'AuthorId'),
            'books' => array(self::MANY_MANY, 'Book', 'book_author(author_id, book_id)')            
		); 

    }

	    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(

            'authorname'	=>	'Author Name',
            'address'		=>	'Address',
            'city'			=>	'City',
            'state'			=>	'State',
            'zip'			=> 	'Zip',
            'email_id'		=>	'Email ID',
            'phone'			=>	'Phone',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('authorname', $this->authorname, true);
        return new CActiveDataProvider($this, array('criteria' => $criteria, ));
    }
	
	public function getAllAuthors()
	{
		$dependency = new CDbCacheDependency('SELECT MAX(update_time) FROM author');
		$dataProvider =  new CActiveDataProvider(self::model()->cache(Yii::app()->params['cacheDuration'], $dependency, 2), array('pagination' => array ('pageSize' => 50)));	 
		return $dataProvider;
	}
	
	public function beforeSave()
	{
		$this->update_time = new CDbExpression('NOW()'); //date("Y-m-d H:i:s");				 
	    return parent::beforeSave();
	}	
}	
