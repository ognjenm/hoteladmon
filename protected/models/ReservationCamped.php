<?php

/**
 * This is the model class for table "reservation_camped".
 *
 * The followings are the available columns in table 'reservation_camped':
 * @property integer $id
 * @property string $type_reservation
 * @property integer $customer_reservation_id
 * @property string $checkin
 * @property string $checkin_hour
 * @property string $checkout
 * @property string $checkout_hour
 * @property integer $adults
 * @property integer $children
 * @property integer $pets
 * @property integer $totalpax
 * @property string $statux
 * @property integer $nigth_ta
 * @property integer $nigth_tb
 * @property integer $nights
 * @property string $price_ta
 * @property string $price_tb
 * @property string $price
 *
 * The followings are the available model relations:
 * @property CustomerReservations $customerReservation
 */
class ReservationCamped extends CActiveRecord
{
    public $checkin_hour;
    public $checkout_hour;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReservationCamped the static model class
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
		return 'reservation_camped';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_reservation, customer_reservation_id', 'required'),
			array('customer_reservation_id, adults, children, pets, totalpax, nigth_ta, nigth_tb, nights', 'numerical', 'integerOnly'=>true),
			array('type_reservation', 'length', 'max'=>7),
			array('statux', 'length', 'max'=>13),
			array('price_ta, price_tb, price, price_early_checkin, price_late_checkout', 'length', 'max'=>10),
			array('checkin,checkin_hour, checkout,checkout_hour', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type_reservation, customer_reservation_id, checkin, checkin_hour, checkout, checkout_hour, adults, children, pets, totalpax, statux, nigth_ta, nigth_tb, nights, price_ta, price_tb, price,price_early_checkin, price_late_checkout', 'safe', 'on'=>'search'),
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
			'customerReservation' => array(self::BELONGS_TO, 'CustomerReservations', 'customer_reservation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'type_reservation' => Yii::t('mx','Type Reservation'),
			'customer_reservation_id' => 'Customer Reservation',
			'checkin' => Yii::t('mx','Check In'),
            'checkin_hour' => Yii::t('mx','Check In Hour'),
			'checkout' => Yii::t('mx','Check Out'),
            'checkout_hour' => Yii::t('mx','Check Out Hour'),
            'adults' => Yii::t('mx','General Admission'),
            'children' => Yii::t('mx','90 cm. to 1.20 mts.'),
			'pets' => '',
			'totalpax' => 'Totalpax',
			'statux' => 'Statux',
			'nigth_ta' => 'Nigth Ta',
			'nigth_tb' => 'Nigth Tb',
			'nights' => 'Nights',
			'price_ta' => 'Price Ta',
			'price_tb' => 'Price Tb',
            'price_early_checkin' => Yii::t('mx','Price Early Checkin'),
            'price_late_checkout' => Yii::t('mx','Price Late Checkout'),
			'price' => 'Price',
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
		$criteria->compare('type_reservation',$this->type_reservation,true);
		$criteria->compare('customer_reservation_id',$this->customer_reservation_id);
		$criteria->compare('checkin',$this->checkin,true);
        $criteria->compare('checkin_hour',$this->checkin_hour,true);
		$criteria->compare('checkout',$this->checkout,true);
        $criteria->compare('checkout_hour',$this->checkout_hour,true);
		$criteria->compare('adults',$this->adults);
		$criteria->compare('children',$this->children);
		$criteria->compare('pets',$this->pets);
		$criteria->compare('totalpax',$this->totalpax);
		$criteria->compare('statux',$this->statux,true);
		$criteria->compare('nigth_ta',$this->nigth_ta);
		$criteria->compare('nigth_tb',$this->nigth_tb);
		$criteria->compare('nights',$this->nights);
		$criteria->compare('price_ta',$this->price_ta,true);
		$criteria->compare('price_tb',$this->price_tb,true);
        $criteria->compare('price_early_checkin',$this->price_early_checkin,true);
        $criteria->compare('price_late_checkout',$this->price_late_checkout,true);
		$criteria->compare('price',$this->price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
		));
	}

    public function getFormDaypass(){

        return array(

            'title' => Yii::t('mx','Daypass'),
            'showErrorSummary' => true,

            'elements'=>array(

                "checkin" => array(
                    'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
                    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                    'mode'=>'datetime',
                    'options'=>array(
                        'showAnim'=>'slide',
                        'changeYear' => true,
                        'changeMonth' => true,
                        'dateFormat'=>Yii::app()->format->dateFormat,
                        'timeText'=> Yii::t('mx','Schedule'),
                        'hourText'=> Yii::t('mx','Hour'),
                        'minuteText'=>Yii::t('mx','Minute'),
                        'timeOnlyTitle'=>Yii::t('mx','Choose Time'),
                        'hour'=>9,
                        'minute'=>00,
                        'hourMin'=>9,
                        'hourMax'=>17,
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),
                ),

                "checkout" => array(
                    'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
                    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                    'mode'=>'datetime',
                    'options'=>array(
                        'showAnim'=>'slide',
                        'changeYear' => true,
                        'changeMonth' => true,
                        'dateFormat'=>Yii::app()->format->dateFormat,
                        'timeText'=> Yii::t('mx','Schedule'),
                        'hourText'=> Yii::t('mx','Hour'),
                        'minuteText'=>Yii::t('mx','Minute'),
                        'timeOnlyTitle'=>Yii::t('mx','Choose Time'),
                        'hour'=>18,
                        'minute'=>00,
                        'hourMin'=>18,
                        'hourMax'=>22,
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),
                ),


                "adults"=>array(
                    'type'=>'text',
                    'class' => 'input-medium',
                ),

                "children"=>array(
                    'type'=>'text',
                    'class' => 'input-medium',
                ),

                "pets"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-medium',
                    'items'=>array(0=>Yii::t('mx','Pets'),1=>1,2=>2,3=>3,4=>4,5=>5),
                ),
            ),
            'buttons' => array(

                'book' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-money',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Budget With Discount'),
                    'url'=>Yii::app()->createUrl('/reservation/dayPassBudget'),
                    'ajaxOptions' => array(
                        'type'=> 'POST',
                        'beforeSend' => 'function() {
                            $("#maindiv").addClass("loading");
                         }',
                        'complete' => 'function() {
                             $("#maindiv").removeClass("loading");
                        }',
                        'success' =>'function(data){
                                $("#detailsGrid").html(data);
                                $("#actions").show();
                        }',
                    ),
                ),

                'undiscountedBudget' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-money',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Undiscounted Budget'),
                    'url'=>Yii::app()->createUrl('/reservation/dayPassUndiscountedBudget'),
                    'ajaxOptions' => array(
                        'type'=> 'POST',
                        'beforeSend' => 'function() {
                            $("#maindiv").addClass("loading");
                         }',
                        'complete' => 'function() {
                             $("#maindiv").removeClass("loading");
                        }',
                        'success' =>'function(data){
                                $("#detailsGrid").html(data);
                                $("#actions").show();
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