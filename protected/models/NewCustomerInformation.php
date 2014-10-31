<?php

class NewCustomerInformation extends CActiveRecord
{
    var $alternative_email_Save;
    var $first_name_Save;
    var $last_name_Save;
    var $country_Save;
    var $state_Save;
    var $city_Save;
    var $home_phone_Save;
    var $work_phone_Save;
    var $cell_phone_Save;

	public function tableName()
	{
		return 'new_customer_information';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id', 'required'),
			array('customer_id, verified', 'numerical', 'integerOnly'=>true),
			array('email, alternative_email, first_name, last_name', 'length', 'max'=>100),
			array('country, state, city, home_phone, work_phone, cell_phone', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, email, alternative_email, first_name, last_name, country, state, city, home_phone, work_phone, cell_phone, verified', 'safe', 'on'=>'search'),
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
			'customer_id' => Yii::t('mx','Customer'),
			'email' => Yii::t('mx','Email'),
			'alternative_email' => Yii::t('mx','Alternative Email'),
			'first_name' => Yii::t('mx','First Name'),
			'last_name' => Yii::t('mx','Last Name'),
			'country' => Yii::t('mx','Country'),
			'state' => Yii::t('mx','State'),
			'city' => Yii::t('mx','City'),
			'home_phone' => Yii::t('mx','Home Phone'),
			'work_phone' => Yii::t('mx','Work Phone'),
			'cell_phone' => Yii::t('mx','Cell Phone'),
			'verified' => Yii::t('mx','Verified'),
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
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('alternative_email',$this->alternative_email,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('home_phone',$this->home_phone,true);
		$criteria->compare('work_phone',$this->work_phone,true);
		$criteria->compare('cell_phone',$this->cell_phone,true);
		$criteria->compare('verified',0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NewCustomerInformation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
