<?php

/**
 * This is the model class for table "rates".
 *
 * The followings are the available columns in table 'rates':
 * @property integer $id
 * @property integer $room_type_id
 * @property integer $type_reservation_id
 * @property string $season
 * @property string $price
 * @property string $adults
 * @property string $children
 * @property string $additional_person
 *
 * The followings are the available model relations:
 * @property Prices[] $prices
 * @property RoomsType $roomType
 * @property TypeReservation $typeReservation
 */
class Rates extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rates the static model class
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
		return 'rates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('room_type_id, type_reservation_id', 'required'),
			array('room_type_id, type_reservation_id', 'numerical', 'integerOnly'=>true),
			array('season', 'length', 'max'=>4),
			array('price, adults, children, additional_person', 'length', 'max'=>10),
            array('service_type', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, room_type_id, type_reservation_id, season, price, adults, children, additional_person', 'safe', 'on'=>'search'),
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
			'prices' => array(self::HAS_MANY, 'Prices', 'rate_id'),
			'roomType' => array(self::BELONGS_TO, 'RoomsType', 'room_type_id'),
			'typeReservation' => array(self::BELONGS_TO, 'TypeReservation', 'type_reservation_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'service_type'=>Yii::t('mx','Service Type'),
			'room_type_id' => Yii::t('mx','Accommodation Type'),
            'type_reservation_id' => Yii::t('mx','Reservation Type'),
            'season' => Yii::t('mx','Season'),
            'price' => Yii::t('mx','Price'),
            'adults' => Yii::t('mx','Arriba de 1.20 mts'),
            'children' => Yii::t('mx','Debajo de 1.20 mts'),
            'additional_person' => Yii::t('mx','Additional Person'),
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
        $criteria->compare('service_type',$this->service_type);
		$criteria->compare('room_type_id',$this->room_type_id);
		$criteria->compare('type_reservation_id',$this->type_reservation_id);
		$criteria->compare('season',$this->season,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('adults',$this->adults,true);
		$criteria->compare('children',$this->children,true);
		$criteria->compare('additional_person',$this->additional_person,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            )
		));
	}

    public function listServiceType(){

        return array(
            'CABANA'=>Yii::t('mx','Cabanas'),
            'TENT'=>Yii::t('mx','Tent'),
            'CAMPED'=>Yii::t('mx','Camped'),
            'DAYPASS'=>Yii::t('mx','Day Pass'),

        );

    }

    /*public function afterFind() {
        $this->service_type=Yii::t('mx',$this->service_type);
    }*/


    public function getPricePerPax($service_type,$room_type_id,$reservationTypeId,$season,$pax){

        $criteria=array(
            'condition'=>'service_type=:serviceType and room_type_id=:roomTypeId and type_reservation_id=:type and season=:season  and pax=:pax',
            'params'=>array(
                ':serviceType'=>$service_type,
                ':roomTypeId'=>$room_type_id,
                ':type'=>$reservationTypeId,
                ':season'=>$season,
                ':pax'=>$pax,
            )
        );

        $value=$this->model()->with(array(
            'prices'=>array(
                'select'=>'pax,price',
                'together'=>true,
                'joinType'=>'INNER JOIN',
            ),
        ))->find($criteria);

        return $value;

    }

    public function getPricePerHeight($service_type,$room_type_id,$reservationTypeId,$season){

        $criteria=array(
            'condition'=>'service_type=:serviceType and room_type_id=:roomTypeId and type_reservation_id=:type and season=:season',
            'params'=>array(
                ':serviceType'=>$service_type,
                ':roomTypeId'=>$room_type_id,
                ':type'=>$reservationTypeId,
                ':season'=>$season
            )
        );

        $value=$this->model()->find($criteria);

        return $value;

    }

    public function behaviors()
    {
        return array(
            'LoggableBehavior'=>
                'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }
}