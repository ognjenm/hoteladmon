<?php

/**
 * This is the model class for table "rooms_type".
 *
 * The followings are the available columns in table 'rooms_type':
 * @property integer $id
 * @property string $tipe
 *
 * The followings are the available model relations:
 * @property Rooms[] $rooms
 */
class RoomsType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RoomsType the static model class
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
		return 'rooms_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipe', 'length', 'max'=>250),
            array('service_type', 'safe'),
            // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tipe', 'safe', 'on'=>'search'),
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
			'rooms' => array(self::HAS_MANY, 'Rooms', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipe' => Yii::t('mx','Type'),
            'service_type'=>Yii::t('mx','Service Type')
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
		$criteria->compare('tipe',$this->tipe,true);
        $criteria->compare('service_type',$this->service_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
		));
	}


    public function listAllRoomsTypes(){

        return CHtml::listData($this->model()->findAll(array('order'=>'tipe')),'id','tipe');

    }

    /*public function afterFind() {
        $this->service_type=Yii::t('mx',$this->service_type);
    }*/

    public function behaviors()
    {
        return array(
            'LoggableBehavior'=>
                'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }
}