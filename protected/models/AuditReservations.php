<?php


class AuditReservations extends CActiveRecord
{

	public function tableName()
	{
		return 'audit_reservations';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_reservation_id, user_id', 'numerical', 'integerOnly'=>true),
			array('action', 'length', 'max'=>20),
			array('field', 'length', 'max'=>64),
			array('old_value, new_value, stamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_reservation_id, old_value, new_value, action, field, stamp, user_id', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'users' => array(self::BELONGS_TO, 'CrugeUser1', 'user_id'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_reservation_id' => Yii::t('mx','Customer Reservation'),
			'old_value' => Yii::t('mx','Old Value'),
			'new_value' => Yii::t('mx','New Value'),
			'action' => Yii::t('mx','Action'),
			'field' => Yii::t('mx','Field'),
			'stamp' => Yii::t('mx','Stamp'),
			'user_id' => Yii::t('mx','User'),
		);
	}


	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('customer_reservation_id',$this->customer_reservation_id);
		$criteria->compare('old_value',$this->old_value,true);
		$criteria->compare('new_value',$this->new_value,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('stamp',$this->stamp,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getColor() {

        $actionColor='white';

        switch ($this->action) {
            case 'CHANGE':  $actionColor='warning'; break;
            case 'DELETE':  $actionColor='error';   break;
            case 'ADD':     $actionColor='success'; break;
        }

        return $actionColor;
    }

    public function afterFind() {

        switch($this->field){
            case 'service_type' :
                $this->new_value=Yii::t('mx',$this->new_value);
                $this->old_value=Yii::t('mx',$this->old_value);
                $this->field= Yii::t('mx','Service Type');
                break;
            case 'room_type_id' :
                $iNewValue=(int)$this->new_value;
                $iOldValue=(int)$this->old_value;
                $newValue=RoomsType::model()->findByPk($iNewValue);
                $oldValue= RoomsType::model()->findByPk($iOldValue);
                if($newValue) $this->new_value=$newValue->tipe;
                if($oldValue) $this->old_value=$oldValue->tipe;
                $this->field= Yii::t('mx','Room Type');
                break;

            case 'room_id' :
                if($this->new_value != 0) {

                    $iNewValue=(int)$this->new_value;
                    $iOldValue=(int)$this->old_value;

                    $newValue=Rooms::model()->findByPk($iNewValue);
                    if($newValue) $this->new_value=$newValue->room;

                    $oldValue= Rooms::model()->findByPk($iOldValue);
                    if($oldValue) $this->old_value=$oldValue->room;
                }

                $this->field= Yii::t('mx','Room');
                break;


            case 'statux' :
                if($this->action=='SET'){
                    $status=Reservation::model()->ArrayStatus();
                    $index=(int)$this->new_value-1;
                    $this->new_value=$status[$index];
                }
                else{
                    $status=Reservation::model()->ArrayStatus();
                    $index=(int)$this->old_value;
                    $this->old_value=$status[$index];
                }
                $this->field= Yii::t('mx','Status');
                break;
            case 'checkin' : $this->field= Yii::t('mx','Checkin'); break;
            case 'checkout' : $this->field= Yii::t('mx','Checkout'); break;
            case 'adults' : $this->field= Yii::t('mx','Adults'); break;
            case 'children' : $this->field= Yii::t('mx','Children'); break;
            case 'pets' : $this->field= Yii::t('mx','Pets'); break;
            case 'customer_reservation_id' : $this->field= Yii::t('mx','Id'); break;
        }

        parent::afterFind();
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
