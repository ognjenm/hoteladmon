<?php

class CustomerReservations extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function tableName()
	{
		return 'customer_reservations';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, see_discount', 'numerical', 'integerOnly'=>true),
			array('total', 'length', 'max'=>10),

			array('id, customer_id', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'customer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
			'reservations' => array(self::HAS_MANY, 'Reservation', 'customer_reservation_id'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_id' => 'Customer',
			'total' => 'Total',
			'see_discount' => 'See Discount',
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('total',$this->total);
        $criteria->compare('see_discount',$this->see_discount);
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
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-search',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Search'),
                    'url'=>Yii::app()->createUrl('/customerReservation/searchReservation'),
                    'ajaxOptions' => array(
                        'type'=>'POST',
                        'dataType'=>'json',
                        'beforeSend' => 'function() { $("#maindiv").addClass("loading"); }',
                        'complete' => 'function() {   $("#maindiv").removeClass("loading"); }',
                        'success' =>'function(data){
                                if(data.ok==true){
                                    CKEDITOR.instances.ckeditorActivities.updateElement();
                                    CKEDITOR.instances.ckeditorActivities.setData(data.budget);
                                    $("#actionsActivities").show();
                                }
                        }',
                    ),
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
}