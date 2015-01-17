<?php


class Rooms extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rooms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('room_type_id', 'required'),
			array('room_type_id, capacity', 'numerical', 'integerOnly'=>true),
			array('room', 'length', 'max'=>10),
			array('image', 'length', 'max'=>50),
			array('image_title, image_title_es', 'length', 'max'=>100),
			array('description, descrition_es', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, room_type_id, capacity, room, image, image_title, image_title_es, description, descrition_es', 'safe', 'on'=>'search'),
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
			'rates' => array(self::HAS_MANY, 'Rates', 'room_id'),
			'reservations' => array(self::HAS_MANY, 'Reservation', 'room_id'),
			'roomType' => array(self::BELONGS_TO, 'RoomsType', 'room_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'room_type_id' => Yii::t('mx','Room Type'),
			'capacity' => Yii::t('mx','Capacity'),
			'room' => Yii::t('mx','Room'),
			'image' => Yii::t('mx','Image'),
			'image_title' => Yii::t('mx','Image Title'),
			'image_title_es' => Yii::t('mx','Image Title Es'),
			'description' => Yii::t('mx','Description'),
			'descrition_es' => Yii::t('mx','Descrition Es'),
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
		$criteria->compare('room_type_id',$this->room_type_id);
		$criteria->compare('capacity',$this->capacity);
		$criteria->compare('room',$this->room,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('image_title',$this->image_title,true);
		$criteria->compare('image_title_es',$this->image_title_es,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('descrition_es',$this->descrition_es,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
		));
	}

    public function listAllRooms(){

        return CHtml::listData($this->model()->findAll(array('order'=>'room')),'id','room');
    }

    public function listAllRoomsNames(){

        return CHtml::listData($this->model()->findAll(array('order'=>'room')),'room','room');
    }

    public function getRoomsJson(){

        $json="[\n";

        $criteriaRoomType=array(
            'select'=>'id,tipe',
        );

        $roomsType=RoomsType::model()->findAll($criteriaRoomType);

        foreach($roomsType as $item):

            $json.="\t{MasterKey:".$item->id.", label:'".$item->tipe."', open: true, children: [\n";

            $criteriaRooms=array(
                'select'=>'id,room',
                'condition'=>'room_type_id=:roomTypeId',
                'params'=>array('roomTypeId'=>$item->id),
            );

            $value=Rooms::model()->findAll($criteriaRooms);

            if($value):
                foreach($value as $rooms):
                    $json.="\t\t{key:".$rooms->id.", label:'".$rooms->room."'},\n";
                endforeach;
            endif;

            $json.="\t]},\n";

        endforeach;

        $json.="]";

        echo $json;

    }

    public function getRoomType($roomid){

        $value=Rooms::model()->with(array(
            'roomType'=>array(
                'select'=>'tipe',
                'together'=>false,
                'joinType'=>'INNER JOIN',
            ),
        ))->findByPk($roomid);

        return $value->roomType->tipe;
    }

    public function getRoomTypeId($roomid){

        $value=Rooms::model()->with(array(
            'roomType'=>array(
                'select'=>'tipe',
                'together'=>true,
                'joinType'=>'INNER JOIN',
            ),
        ))->findByPk($roomid);

        return $value->roomType->id;
    }

    public function getRoomsavailable($roomUnavailable,$roomType){

        if($roomUnavailable!=NULL){
            $sql="select * from rooms where room_type_id=".$roomType." and id not in(".implode(',',$roomUnavailable).") order by uso";
            $options = CHtml::listData(Rooms::model()->findAllBySql($sql),'id','room');
        }
        else{

            $criteria=array(
                'condition'=>'room_type_id=:roomType',
                'params'=>array('roomType'=>$roomType),
                'order'=>'uso'
            );

            $options = CHtml::listData(Rooms::model()->findAll($criteria),'id','room');
        }

        return $options;

    }

    public function behaviors()
    {
        return array(
            'LoggableBehavior'=>
                'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }
}