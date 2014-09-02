<?php

/**
 * This is the model class for table "settings".
 *
 * The followings are the available columns in table 'settings':
 * @property integer $id
 * @property string $price_per_pet
 * @property integer $days_limit_of_payment
 * @property integer $early_payment
 * @property string $early_checkin_price
 * @property string $late_checkout_price
 * @property string $early_checkin
 * @property string $late_checkout
 * @property string $early_checkin_daypass
 * @property string $late_checkout_daypass
 * @property string $rfc
 * @property string $company_name
 * @property integer $regime
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
 * @property string $phones
 * @property string $cells
 * @property string $fax
 * @property string $email
 * @property string $email_alternative
 * @property string $tax
 * @property string $tax_lodgin
 */
class Settings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('days_limit_of_payment, early_payment, regime', 'numerical', 'integerOnly'=>true),
			array('price_per_pet, early_checkin_price, late_checkout_price, tax, tax_lodgin', 'length', 'max'=>10),
			array('early_checkin, late_checkout, early_checkin_daypass, late_checkout_daypass', 'length', 'max'=>20),
			array('rfc, fax', 'length', 'max'=>25),
			array('company_name, reference', 'length', 'max'=>200),
			array('street, neighborhood, locality, municipality, email, email_alternative', 'length', 'max'=>100),
			array('outside_number, internal_number, state, country, zipcode', 'length', 'max'=>50),
			array('phones, cells', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, price_per_pet, days_limit_of_payment, early_payment, early_checkin_price, late_checkout_price, early_checkin, late_checkout, early_checkin_daypass, late_checkout_daypass, rfc, company_name, regime, street, outside_number, internal_number, neighborhood, locality, reference, municipality, state, country, zipcode, phones, cells, fax, email, email_alternative, tax, tax_lodgin', 'safe', 'on'=>'search'),
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
            'price_per_pet' => Yii::t('mx','Price Per Pet'),
            'days_limit_of_payment' => Yii::t('mx','Days Limit Of Payment'),
            'early_payment' => Yii::t('mx','Early Payment'),
            'early_checkin_price' => Yii::t('mx','Early Checkin Price'),
            'late_checkout_price' => Yii::t('mx','Late Checkout Price'),
            'early_checkin' => Yii::t('mx','Early Checkin'),
            'late_checkout' => Yii::t('mx','Late Checkout'),
            'early_checkin_daypass' => Yii::t('mx','Early Checkin Daypass'),
            'late_checkout_daypass' => Yii::t('mx','Late Checkout Daypass'),
            'rfc' => Yii::t('mx','Rfc'),
            'company_name' => Yii::t('mx','Company Name'),
            'regime' => Yii::t('mx','Regime'),
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
            'phones' => Yii::t('mx','Phones'),
            'cells' => Yii::t('mx','Cells'),
            'fax' => Yii::t('mx','Fax'),
            'email' => Yii::t('mx','Email'),
            'email_alternative' => Yii::t('mx','Email Alternative'),
            'tax' => Yii::t('mx','Tax'),
			'tax_lodgin' => Yii::t('mx','Tax Lodging'),
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
		$criteria->compare('price_per_pet',$this->price_per_pet,true);
		$criteria->compare('days_limit_of_payment',$this->days_limit_of_payment);
		$criteria->compare('early_payment',$this->early_payment);
		$criteria->compare('early_checkin_price',$this->early_checkin_price,true);
		$criteria->compare('late_checkout_price',$this->late_checkout_price,true);
		$criteria->compare('early_checkin',$this->early_checkin,true);
		$criteria->compare('late_checkout',$this->late_checkout,true);
		$criteria->compare('early_checkin_daypass',$this->early_checkin_daypass,true);
		$criteria->compare('late_checkout_daypass',$this->late_checkout_daypass,true);
		$criteria->compare('rfc',$this->rfc,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('regime',$this->regime);
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
		$criteria->compare('phones',$this->phones,true);
		$criteria->compare('cells',$this->cells,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('email_alternative',$this->email_alternative,true);
		$criteria->compare('tax',$this->tax,true);
		$criteria->compare('tax_lodgin',$this->tax_lodgin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getForm(){

        return array(
            'title'=>Yii::t('mx','Settings'),

            'elements'=>array(

                "price_per_pet"=>array(
                    'type' => 'text',
                    'prepend'=>'$',
                ),
                "days_limit_of_payment"=>array(
                    'type' => 'text',
                    'prepend'=>'#',
                ),
                "early_payment"=>array(
                    'type' => 'text',
                    'prepend'=>'%',
                ),
                "days_limit_of_payment"=>array(
                    'type' => 'text',
                    'prepend'=>'#',
                ),
                "early_checkin_price"=>array(
                    'type' => 'text',
                    'prepend'=>'$',
                ),
                "late_checkout_price"=>array(
                    'type' => 'text',
                    'prepend'=>'$',
                ),
                "early_checkin"=>array(
                    'type' => 'text',
                    'prepend'=>'<i class="icon-time"></i>',
                ),
                "late_checkout"=>array(
                    'type' => 'text',
                    'prepend'=>'<i class="icon-time"></i>',
                ),
                "early_checkin_daypass"=>array(
                    'type' => 'text',
                    'prepend'=>'<i class="icon-time"></i>',
                ),
                "late_checkout_daypass"=>array(
                    'type' => 'text',
                    'prepend'=>'<i class="icon-time"></i>',
                ),
                "rfc"=>array(
                    'type' => 'text',
                ),
                "company_name"=>array(
                    'type' => 'text',
                ),
                "regime"=>array(
                    'type' => 'dropdownlist',
                    'items'=>array(1=>Yii::t('mx','Individual'),2=>Yii::t('mx','Moral Person')),
                    'prompt'=>Yii::t('mx','Select'),
                ),

                "street"=>array(
                    'type' => 'text',
                ),
                "outside_number"=>array(
                    'type' => 'text',
                    'prepend'=>'#',
                ),
                "internal_number"=>array(
                    'type' => 'text',
                    'prepend'=>'#',
                ),
                "neighborhood"=>array(
                    'type' => 'text',
                ),
                "locality"=>array(
                    'type' => 'text',
                ),
                "reference"=>array(
                    'type' => 'text',
                ),
                "municipality"=>array(
                    'type' => 'text',
                ),
                "state"=>array(
                    'type' => 'text',
                ),
                "country"=>array(
                    'type' => 'text',
                ),

                "zipcode"=>array(
                    'type' => 'text',
                ),

                "phones"=>array(
                    'type' => 'text',
                    'prepend'=>'<i class="icon-phone"></i>',
                ),
                "cells"=>array(
                    'type' => 'text',
                    'prepend'=>'<i class="icon-mobile-phone"></i>',
                ),
                "fax"=>array(
                    'type' => 'text',
                    'prepend'=>'<i class="icon-phone"></i>',
                ),
                "email"=>array(
                    'type' => 'text',
                    'prepend'=>'@',
                ),
                "email_alternative"=>array(
                    'type' => 'text',
                    'prepend'=>'@',
                ),
                "tax"=>array(
                    'type' => 'text',
                    'prepend'=>'%',
                ),
                "tax_lodgin"=>array(
                    'type' => 'text',
                    'prepend'=>'%',
                ),
            ),
            'buttons' => array(
                'send' => array(
                    'type' => 'submit',
                    'label' => Yii::t('mx','Save'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-ok',
                ),
            )
        );
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
