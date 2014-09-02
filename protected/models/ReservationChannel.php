<?php

/**
 * This is the model class for table "reservation_channel".
 *
 * The followings are the available columns in table 'reservation_channel':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Poll[] $polls
 */
class ReservationChannel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reservation_channel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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
			'polls' => array(self::HAS_MANY, 'Poll', 'reservation_channel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
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
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listReservationChannel(){
        return CHtml::listData($this->model()->findAll(array('order'=>'id')),'id','name');
    }

    public function getForm()
    {
        return array(
            //'title' => Yii::t('mx','How we contact the customer?'),
            'showErrorSummary' => true,
            'elements' => array(

                'name'=>array(
                    'type'=>'text',
                    'class' => 'input-large',
                    'prepend'=>'<i class="icon-user"></i>'
                ),
            ),

            'buttons' => array(

                'save' => array(
                    'type' => 'ajaxSubmit',
                    'label' => Yii::t('mx','Save'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-ok',
                    'url'=>Yii::app()->createUrl('/reservationChannel/create'),
                    'ajaxOptions' => array(
                        'type'=>'POST',
                        'dataType'=>'json',
                        'beforeSend' => 'function() { $("#saveReservationChannel").addClass("saving"); }',
                        'complete' => 'function() { $("#saveReservationChannel1").removeClass("saving"); }',
                        'success' =>'function(data){ if(data.ok==true) $("#reservationChannel").modal("hide"); }',
                    ),
                ),

            )
        );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReservationChannel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'LoggableBehavior'=>
                'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }
}
