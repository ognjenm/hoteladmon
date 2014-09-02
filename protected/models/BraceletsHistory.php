<?php

/**
 * This is the model class for table "bracelets_history".
 *
 * The followings are the available columns in table 'bracelets_history':
 * @property integer $id
 * @property integer $assignment_id
 * @property string $operation
 * @property integer $quantity
 * @property string $register
 * @property string $datex
 * @property integer $existence
 * @property string $movement
 * @property integer $balance
 *
 * The followings are the available model relations:
 * @property Assignment $assignment
 */
class BraceletsHistory extends CActiveRecord
{
    public $employeed_id;
    public $folio;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bracelets_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operation', 'required'),
			array('id, employeed_id, assignment_id, quantity, existence, balance', 'numerical', 'integerOnly'=>true),
			array('operation', 'length', 'max'=>13),
			array('register,folio', 'length', 'max'=>100),
			array('movement', 'length', 'max'=>20),
			array('datex', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, assignment_id, operation, quantity, register, datex, existence, movement, balance', 'safe', 'on'=>'search'),
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
			'assignment' => array(self::BELONGS_TO, 'Assignment', 'assignment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'assignment_id' => Yii::t('mx','Transfer From'),
			'operation' => Yii::t('mx','Operation'),
			'quantity' => Yii::t('mx','Quantity'),
			'register' => Yii::t('mx','Register'),
			'datex' => Yii::t('mx','Date'),
			'existence' => Yii::t('mx','Existence'),
			'movement' => Yii::t('mx','Movement'),
			'balance' => Yii::t('mx','Balance'),
            'employeed_id'=>Yii::t('mx','Transfer To')
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
		$criteria->compare('assignment_id',$this->assignment_id);
		$criteria->compare('operation',$this->operation,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('register',$this->register,true);
		$criteria->compare('datex',$this->datex,true);
		$criteria->compare('existence',$this->existence);
		$criteria->compare('movement',$this->movement,true);
		$criteria->compare('balance',$this->balance);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listOperations(){

        return array(
            'TRANSFERENCIA'=>'TRANSFERENCIA',
            'VENTA'=>Yii::t('mx','VENTA'),
        );

    }

    public function beforeSave(){

        $date=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->datex);
        $this->datex=date("Y-m-d",strtotime($date));

        return parent::beforeSave();

    }

    public function afterFind() {

        $this->datex=date("d-M-Y",strtotime($this->datex));

        return  parent::afterFind();
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'LoggableBehavior'=>
                'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }
}
