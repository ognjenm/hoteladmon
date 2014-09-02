<?php

/**
 * This is the model class for table "customer_reservations".
 *
 * The followings are the available columns in table 'customer_reservations':
 * @property integer $id
 * @property integer $customer_id
 * @property string $email
 * @property string $alternative_email
 * @property string $first_name
 * @property string $last_name
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $how_find_us
 * @property string $home_phone
 * @property string $work_phone
 * @property string $cell_phone
 * @property string $subtotal
 * @property string $cabana_discount
 * @property string $tent_discount
 * @property string $camped_discount
 * @property string $day_pass_discount
 * @property string $grand_total
 * @property integer $see_discount
 *
 * The followings are the available model relations:
 * @property Customers $customer
 * @property Reservation[] $reservations
 */
class CustomerReservations extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CustomerReservations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer_reservations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
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

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'customer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
			'reservations' => array(self::HAS_MANY, 'Reservation', 'customer_reservation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_id' => 'Customer',
			'total' => 'Total',
			'see_discount' => 'See Discount',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
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

    public function behaviors()
    {
        return array(
            'LoggableBehavior'=>
                'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }
}