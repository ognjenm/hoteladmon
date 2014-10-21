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
			array('date_signing_contract', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, employee_id, contract_type, object, need, date_signing_contract', 'safe', 'on'=>'search'),
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
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('contract_type',$this->contract_type,true);
		$criteria->compare('object',$this->object,true);
		$criteria->compare('need',$this->need,true);
		$criteria->compare('date_signing_contract',$this->date_signing_contract,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContractEmployees the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
