<?php

/**
 * This is the model class for table "charges".
 *
 * The followings are the available columns in table 'charges':
 * @property integer $id
 * @property integer $customer_reservation_id
 * @property integer $concept_id
 * @property string $description
 * @property string $amount
 * @property string $datex
 * @property string $stampt
 * @property integer $user_id
 * @property string $guest_name
 *
 * The followings are the available model relations:
 * @property Concepts $concept
 * @property CustomerReservations $customerReservation
 */
class Charges extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'charges';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_reservation_id, concept_id, user_id, guest_name', 'required'),
			array('customer_reservation_id, concept_id, user_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>10),
			array('guest_name', 'length', 'max'=>150),
			array('description, datex, stampt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_reservation_id, concept_id, description, amount, datex, stampt, user_id, guest_name', 'safe', 'on'=>'search'),
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
			'concepto' => array(self::BELONGS_TO, 'Concepts', 'concept_id'),
			'customerReservation' => array(self::BELONGS_TO, 'CustomerReservations', 'customer_reservation_id'),
            'user' => array(self::BELONGS_TO, 'CrugeUser1', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_reservation_id' => Yii::t('mx','Customer Reservation'),
			'concept_id' => Yii::t('mx','Concept'),
			'description' => Yii::t('mx','Description'),
			'amount' => Yii::t('mx','Amount'),
			'datex' => Yii::t('mx','Date'),
            'stampt' => Yii::t('mx','Date And Time Of Registration'),
			'user_id' => Yii::t('mx','User'),
			'guest_name' => Yii::t('mx','Guest Name'),
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
		$criteria->compare('customer_reservation_id',$this->customer_reservation_id);
		$criteria->compare('concept_id',$this->concept_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('datex',$this->datex,true);
		$criteria->compare('stampt',$this->stampt,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('guest_name',$this->guest_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function getForm($customerId=null){

        return array(
            'id'=>'payments-form',
            //'title' => Yii::t('mx','Charges'),
            'showErrorSummary' => true,
            'elements'=>array(

                'concept_id'=>array(
                    'type'=>'dropdownlist',
                    'items'=>Concepts::model()->listAll(),
                    'prompt'=>Yii::t('mx','Select')
                ),

                'description'=>array(
                    'type'=>'text',
                ),

                'amount'=>array(
                    'type'=>'text',
                    'maxlength'=>10,
                    'prepend'=>'$',
                ),
                'guest_name'=>array(
                    'type'=>'text',
                    'prepend'=>'<i class="icon-user"></i>',
                ),
                'datex' => array(
                    'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
                    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                    'mode'=>'date',
                    'options'=>array(
                        'showAnim'=>'slide',
                        'dateFormat'=>Yii::app()->format->dateFormat,
                        'changeYear' => true,
                        'changeMonth' => true,

                    ),
                    /*'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),*/
                ),

            ),

            'buttons' => array(

                'budget' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Save'),
                    'url'=>Yii::app()->createUrl('/charges/create',array('id'=>$customerId)),
                    'ajaxOptions' => array(
                        'dataType'=>'json',
                        'beforeSend' => 'function() {
                            $("#messages").addClass("saving");
                         }',
                        'complete' => 'function() {
                             $("#messages").removeClass("saving");
                        }',
                        'success' =>'function(data){
                            if(data.ok==true){

                                $("#charges-grid").yiiGridView("update", {
                                        data: $(this).serialize()
                                 });

                                $("#charge-modal").modal("hide");

                            }
                        }',
                    ),
                ),

            )
        );
    }

    public function beforeSave(){

        $fecha=Yii::app()->quoteUtil->toEnglishDate($this->datex);
        $this->datex=date("Y-m-d",strtotime($fecha));

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
