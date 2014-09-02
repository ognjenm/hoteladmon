<?php

/**
 * This is the model class for table "tax_information".
 *
 * The followings are the available columns in table 'tax_information':
 * @property integer $id
 * @property integer $customer_id
 * @property string $bill
 * @property string $rfc
 * @property string $company_name
 * @property string $street
 * @property string $outside_number
 * @property string $internal_number
 * @property string $neighborhood
 * @property string $locality
 * @property string $reference
 * @property string $municipality
 * @property string $state
 * @property string $country
 * @property string $zipcode
 */
class TaxInformation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tax_information';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id', 'numerical', 'integerOnly'=>true),
			array('bill, company_name, reference', 'length', 'max'=>200),
			array('rfc', 'length', 'max'=>25),
			array('street, neighborhood, locality, municipality', 'length', 'max'=>100),
			array('outside_number, internal_number, state, country, zipcode', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, bill, rfc, company_name, street, outside_number, internal_number, neighborhood, locality, reference, municipality, state, country, zipcode', 'safe', 'on'=>'search'),
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
			'bill' => Yii::t('mx','Bill'),
			'rfc' => Yii::t('mx','Rfc'),
			'company_name' => Yii::t('mx','Company Name'),
			'street' => Yii::t('mx','Street'),
			'outside_number' => Yii::t('mx','Outside Number'),
			'internal_number' => Yii::t('mx','Internal Number'),
			'neighborhood' => Yii::t('mx','Neighborhood'),
			'locality' => Yii::t('mx','Locality'),
			'reference' => Yii::t('mx','Reference'),
			'municipality' => Yii::t('mx','Municipality'),
			'state' => Yii::t('mx','State'),
			'country' => Yii::t('mx','Country'),
			'zipcode' => Yii::t('mx','Zip Code'),
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
		$criteria->compare('bill',$this->bill,true);
		$criteria->compare('rfc',$this->rfc,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('outside_number',$this->outside_number,true);
		$criteria->compare('internal_number',$this->internal_number,true);
		$criteria->compare('neighborhood',$this->neighborhood,true);
		$criteria->compare('locality',$this->locality,true);
		$criteria->compare('reference',$this->reference,true);
		$criteria->compare('municipality',$this->municipality,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('zipcode',$this->zipcode,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaxInformation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
