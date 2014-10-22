<?php

/**
 * This is the model class for table "contract_employees".
 *
 * The followings are the available columns in table 'contract_employees':
 * @property integer $id
 * @property integer $employee_id
 * @property string $contract_type
 * @property string $object
 * @property string $need
 * @property string $date_signing_contract
 * @property string $contract
 */
class ContractEmployees extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contract_employees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_id', 'required'),
			array('employee_id', 'numerical', 'integerOnly'=>true),
			array('contract_type, object, need', 'length', 'max'=>500),
			array('date_signing_contract, contract', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, employee_id, contract_type, object, need, date_signing_contract, contract', 'safe', 'on'=>'search'),
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
            'employee' => array(self::BELONGS_TO, 'Employees', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',

            'employee_id' => Yii::t('mx','Employee'),
            'contract_type' => Yii::t('mx','Contract Type'),
            'object' => Yii::t('mx','Object'),
            'need' => Yii::t('mx','Need'),
            'date_signing_contract' => Yii::t('mx','Date Signing Contract'),
            'contract' => Yii::t('mx','Contract'),
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('contract_type',$this->contract_type,true);
		$criteria->compare('object',$this->object,true);
		$criteria->compare('need',$this->need,true);
		$criteria->compare('date_signing_contract',$this->date_signing_contract,true);
		$criteria->compare('contract',$this->contract,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterFind() {

        $this->date_signing_contract=Yii::app()->quoteUtil->toSpanishDateFromDb(date('Y-M-d',strtotime($this->date_signing_contract)));

        return  parent::afterFind();
    }

    public function beforeSave(){

        $date_signing_contract=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->date_signing_contract);
        $this->date_signing_contract=date("Y-m-d",strtotime($date_signing_contract));

        return parent::beforeSave();

    }


    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
