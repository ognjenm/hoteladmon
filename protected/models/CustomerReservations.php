<?php


class CustomerReservations extends CActiveRecord
{

	public function tableName()
	{
		return 'customer_reservations';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, see_discount, first_payment, have_commission', 'numerical', 'integerOnly'=>true),
			array('subtotal, discount_cabana, discount_camped, discount_daypass, commission, total', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, subtotal, discount_cabana, discount_camped, discount_daypass, commission, total, see_discount, first_payment, have_commission', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'payments' => array(self::HAS_MANY, 'Payments', 'customer_reservation_id'),
            'customer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
            'reservations' => array(self::HAS_MANY, 'Reservation', 'customer_reservation_id')
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
            'subtotal' => Yii::t('mx','Subtotal'),
            'discount_cabana' => Yii::t('mx','Discount Cabana'),
            'discount_camped' => Yii::t('mx','Discount Camped'),
            'discount_daypass' => 'Discount Daypass',
            'commission' => Yii::t('mx','Commission'),
            'total' => Yii::t('mx','Total'),
            'see_discount' => Yii::t('mx','See Discount'),
            'first_payment' => Yii::t('mx','First Payment'),
            'have_commission' => Yii::t('mx','Have Commission'),
		);
	}

    public function search(){

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('customer_id',$this->customer_id);
        $criteria->compare('subtotal',$this->subtotal,true);
        $criteria->compare('discount_cabana',$this->discount_cabana,true);
        $criteria->compare('discount_camped',$this->discount_camped,true);
        $criteria->compare('discount_daypass',$this->discount_daypass,true);
        $criteria->compare('commission',$this->commission,true);
        $criteria->compare('total',$this->total);
        $criteria->compare('see_discount',$this->see_discount);
        $criteria->compare('have_commission',$this->have_commission);
        $criteria->select='customer_id';

        $criteria->with = array(
            'customer' => array(
                'select'=>'customer.first_name',
                'joinType' => 'INNER JOIN',
            ),
            'reservations' => array(
                'select'=>'reservations.checkin,reservations.checkout,reservations.statux',
                'joinType' => 'INNER JOIN',
            )
        );

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));

    }

    public function getForm(){

        return array(

            'elements'=>array(
                "customer_id"=>array(
                    'type'=>'select2',
                    'data'=>Customers::model()->listFullname(),
                    'prompt'=>Yii::t('mx','Select'),
                ),
            ),

            'buttons' => array(
                'search' => array(
                    'id'=>'buttonSearchCustomerReservation',
                    'type' => 'submit',
                    'icon'=>'icon-search',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Search'),
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
