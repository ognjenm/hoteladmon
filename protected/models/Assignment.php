<?php

/**
 * This is the model class for table "assignment".
 *
 * The followings are the available columns in table 'assignment':
 * @property integer $id
 * @property integer $employeed_id
 * @property integer $bracelet_id
 * @property integer $initial_amount
 * @property integer $minimum_balance
 * @property string $date_assignment
 * @property integer $balance
 *
 * The followings are the available model relations:
 * @property Bracelets $bracelet
 * @property Employees $employeed
 */
class Assignment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'assignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employeed_id, bracelet_id, date_assignment', 'required'),
			array('employeed_id, bracelet_id, initial_amount, minimum_balance, balance', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, employeed_id, bracelet_id, initial_amount, minimum_balance, date_assignment, balance', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'employeed' => array(self::BELONGS_TO, 'Employees', 'employeed_id','order'=>'names'),
            'bracelet' => array(self::BELONGS_TO, 'Bracelets', 'bracelet_id'),
            'braceletsHistories' => array(self::HAS_MANY, 'BraceletsHistory', 'assignment_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'employeed_id' => Yii::t('mx','Employeed'),
			'bracelet_id' => Yii::t('mx','Bracelet'),
			'initial_amount' => Yii::t('mx','Initial Amount'),
			'minimum_balance' => Yii::t('mx','Saldo Minimo'),
			'date_assignment' => Yii::t('mx','Date Assignment'),
			'balance' => Yii::t('mx','Balance'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('employeed_id',$this->employeed_id);
		$criteria->compare('bracelet_id',$this->bracelet_id);
		$criteria->compare('initial_amount',$this->initial_amount);
		$criteria->compare('minimum_balance',$this->minimum_balance);
		$criteria->compare('date_assignment',$this->date_assignment,true);
		$criteria->compare('balance',$this->minimum_balance);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'employeed_id',
                ),
                'defaultOrder'=>array(
                    'employeed_id'=>CSort::SORT_ASC,
                )
            ),
        ));
	}


    public function minimos()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('employeed_id',$this->employeed_id);
        $criteria->compare('bracelet_id',$this->bracelet_id);
        $criteria->compare('initial_amount',$this->initial_amount);
        $criteria->compare('minimum_balance',$this->minimum_balance);
        $criteria->compare('date_assignment',$this->date_assignment,true);
        $criteria->compare('balance','<='.(int)$this->minimum_balance);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'employeed_id',
                ),
                'defaultOrder'=>array(
                    'employeed_id'=>CSort::SORT_ASC,
                )
            ),
        ));
    }

    public function listAllBracelets(){
        $lista=array();
        $result=$this->model()->findAll(array('order'=>'employeed_id'));

        foreach($result as $item){
            $lista[$item->id]=$item->employeed->names.' - '.$item->bracelet->color.' - '.$item->balance;
        }

        if($lista !=null) return $lista;
        else return array('prompt'=>Yii::t('mx','Select'));

    }

    public function getMarkMinimum() {

        $balance='white';

        if($this->balance <= $this->minimum_balance){
            $balance='error';
        }

        return $balance;

    }

    public function afterFind() {

        $this->date_assignment=date("d-M-Y",strtotime($this->date_assignment));

        return  parent::afterFind();
    }

    public function beforeSave(){

        $date=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->date_assignment);
        $this->date_assignment=date("Y-m-d",strtotime($date));

        return parent::beforeSave();

    }


    public function behaviors()
    {
        return array(
            'LoggableBehavior'=>
                'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }


    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
