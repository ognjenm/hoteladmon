<?php

class ContractInformation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contract_information';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('service_id', 'required'),
			array('gender_lessee, gender_owner, property_type, has_surety, gender_surety, is_iva, iva_percent, is_isr, isr_percent, is_retiva, service_id, iscompany_lessee, iscompany_owner', 'numerical', 'integerOnly'=>true),
			array('lessee', 'length', 'max'=>255),
			array('owner, paydays, forced_months, name_surety, title', 'length', 'max'=>100),
			array('property_location, address_payment, address_surety, property_address_surety', 'length', 'max'=>500),
			array('amount_rent, payment_services, monthly_payment_arrears, new_rent_payment, monthly_payment_increase, penalty_nonpayment, deposit_guarantee, iva, isr, retiva, total, total_amount', 'length', 'max'=>10),
			array('company_lessee, company_owner', 'length', 'max'=>150),
			array('rfc_lessee', 'length', 'max'=>25),
			array('inception_lease, end_lease, address_public_register, date_signature, content, address_public_register_lessee', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lessee, gender_lessee, owner, gender_owner, property_location, property_type, address_payment, paydays, amount_rent, forced_months, inception_lease, end_lease, payment_services, monthly_payment_arrears, new_rent_payment, monthly_payment_increase, penalty_nonpayment, deposit_guarantee, has_surety, name_surety, gender_surety, address_surety, property_address_surety, address_public_register, date_signature, title, content, is_iva, iva_percent, iva, is_isr, isr_percent, isr, is_retiva, retiva, total, service_id, iscompany_lessee, company_lessee, rfc_lessee, iscompany_owner, company_owner, total_amount, address_public_register_lessee', 'safe', 'on'=>'search'),
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
            'services' => array(self::BELONGS_TO, 'Services', 'service_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'lessee' => Yii::t('mx','Lessee'),
            'gender_lessee' => Yii::t('mx','Gender of lessee'),
            'owner' => Yii::t('mx','Owner'),
            'gender_owner' => Yii::t('mx','Gender of owner'),
            'property_location' => Yii::t('mx','Location of the property to be rented'),
            'property_type' => Yii::t('mx','Property type'),
            'address_payment' => Yii::t('mx','Address where you will make the monthly payment of the amount of the rent'),
            'paydays' => Yii::t('mx','The rent payment is made ​​monthly within'),
            'amount_rent' => Yii::t('mx','Amount Of Rent'),
            'forced_months' => Yii::t('mx','Forced Months'),
            'inception_lease' => Yii::t('mx','Inception Of The Lease'),
            'end_lease' => Yii::t('mx','End Of The Lease'),
            'payment_services' => Yii::t('mx','Payment For Services'),
            'monthly_payment_arrears' => Yii::t('mx','It is expressly agreed and accepted that rents in arrears constituted cause interest at'),
            'new_rent_payment' => Yii::t('mx','New rental payment by contract expiration and no vacate the property'),
            'monthly_payment_increase' => Yii::t('mx','Percentage of monthly interest that the new monthly rent will increase if they continue no vacate the property'),
            'penalty_nonpayment' => Yii::t('mx','Percentage of penalty for delay or failure in payments'),
            'deposit_guarantee' => Yii::t('mx','Deposit  Of Guarantee'),
            'has_surety' =>  Yii::t('mx','Has Surety'),
            'name_surety' => Yii::t('mx','Name Of The Surety'),
            'gender_surety' => Yii::t('mx','Gender surety'),
            'address_surety' => Yii::t('mx','Address Of The Surety'),
            'property_address_surety' => Yii::t('mx','Address of the property of guarantor remains as collateral'),
            'address_public_register' => Yii::t('mx','Data writing and inscription in the Property RPPC guarantor'),
            'date_signature' => Yii::t('mx','Date Of Signature'),
            'title' => Yii::t('mx','Filename of this contract'),
            'content' => Yii::t('mx','Content'),
            'is_iva' => Yii::t('mx','Applies IVA'),
            'iva_percent' => Yii::t('mx','Percentage of VAT'),
            'iva' => Yii::t('mx','IVA'),
            'is_isr' => Yii::t('mx','Applies ISR'),
            'isr_percent' => Yii::t('mx','Percentage of ISR'),
            'isr' => Yii::t('mx','ISR'),
            'is_retiva' => Yii::t('mx','Retention of IVA applies'),
            'retiva' => Yii::t('mx','Retention of IVA'),
            'total' => Yii::t('mx','Total'),
            'service_id' => Yii::t('mx','Name of services'),
            'iscompany_lessee' => Yii::t('mx','The lessee is a company'),
            'company_lessee' => Yii::t('mx','Company Name').' ('.Yii::t('mx','Lessee').')',
            'rfc_lessee' => Yii::t('mx','RFC').' ('.Yii::t('mx','Lessee').')',
            'iscompany_owner' => Yii::t('mx','The owner is company'),
            'company_owner' => Yii::t('mx','Company Name').' ('.Yii::t('mx','Owner').')',
            'total_amount' => Yii::t('mx','Lease amount after VAT, ISR, RETIVA'),
			'address_public_register_lessee' => Yii::t('mx','Address Public Register Lessee'),
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('lessee',$this->lessee,true);
		$criteria->compare('gender_lessee',$this->gender_lessee);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('gender_owner',$this->gender_owner);
		$criteria->compare('property_location',$this->property_location,true);
		$criteria->compare('property_type',$this->property_type);
		$criteria->compare('address_payment',$this->address_payment,true);
		$criteria->compare('paydays',$this->paydays,true);
		$criteria->compare('amount_rent',$this->amount_rent,true);
		$criteria->compare('forced_months',$this->forced_months,true);
		$criteria->compare('inception_lease',$this->inception_lease,true);
		$criteria->compare('end_lease',$this->end_lease,true);
		$criteria->compare('payment_services',$this->payment_services,true);
		$criteria->compare('monthly_payment_arrears',$this->monthly_payment_arrears,true);
		$criteria->compare('new_rent_payment',$this->new_rent_payment,true);
		$criteria->compare('monthly_payment_increase',$this->monthly_payment_increase,true);
		$criteria->compare('penalty_nonpayment',$this->penalty_nonpayment,true);
		$criteria->compare('deposit_guarantee',$this->deposit_guarantee,true);
		$criteria->compare('has_surety',$this->has_surety);
		$criteria->compare('name_surety',$this->name_surety,true);
		$criteria->compare('gender_surety',$this->gender_surety);
		$criteria->compare('address_surety',$this->address_surety,true);
		$criteria->compare('property_address_surety',$this->property_address_surety,true);
		$criteria->compare('address_public_register',$this->address_public_register,true);
		$criteria->compare('date_signature',$this->date_signature,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('is_iva',$this->is_iva);
		$criteria->compare('iva_percent',$this->iva_percent);
		$criteria->compare('iva',$this->iva,true);
		$criteria->compare('is_isr',$this->is_isr);
		$criteria->compare('isr_percent',$this->isr_percent);
		$criteria->compare('isr',$this->isr,true);
		$criteria->compare('is_retiva',$this->is_retiva);
		$criteria->compare('retiva',$this->retiva,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('iscompany_lessee',$this->iscompany_lessee);
		$criteria->compare('company_lessee',$this->company_lessee,true);
		$criteria->compare('rfc_lessee',$this->rfc_lessee,true);
		$criteria->compare('iscompany_owner',$this->iscompany_owner);
		$criteria->compare('company_owner',$this->company_owner,true);
		$criteria->compare('total_amount',$this->total_amount,true);
		$criteria->compare('address_public_register_lessee',$this->address_public_register_lessee,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listGender(){
        return array(
            1=>Yii::t('mx','Male'),
            2=>Yii::t('mx','Female')
        );
    }

    public function  displayGender($index){

        $sex=array(
            1=>Yii::t('mx','Male'),
            2=>Yii::t('mx','Female')
        );

        return $sex[$index];
    }

    public function afterFind() {

        $this->inception_lease=date('d-M-Y',strtotime($this->inception_lease));
        $this->end_lease=date('d-M-Y',strtotime($this->end_lease));
        $this->date_signature=date('d-M-Y',strtotime($this->date_signature));

        $this->amount_rent=number_format($this->amount_rent,2);
        $this->payment_services=number_format($this->payment_services,2);
        $this->new_rent_payment=number_format($this->new_rent_payment,2);
        $this->deposit_guarantee=number_format($this->deposit_guarantee,2);

        return  parent::afterFind();
    }

    public function beforeSave(){

        $inception_lease=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->inception_lease);
        $end_lease=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->end_lease);
        $date_signature=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->date_signature);

        $this->inception_lease=date("Y-m-d",strtotime($inception_lease));
        $this->end_lease=date("Y-m-d",strtotime($end_lease));
        $this->date_signature=date("Y-m-d",strtotime($date_signature));

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
