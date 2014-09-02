<?php

/**
 * This is the model class for table "poll".
 *
 * The followings are the available columns in table 'poll':
 * @property integer $id
 * @property string $medio
 * @property integer $sales_agent_id
 * @property string $used_email
 * @property string $arrived_email
 * @property integer $reservation_channel_id
 *
 * The followings are the available model relations:
 * @property SalesAgents $salesAgent
 * @property ReservationChannel $reservationChannel
 */
class Poll extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'poll';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sales_agent_id, reservation_channel_id,customer_reservation_id', 'numerical', 'integerOnly'=>true),
			array('medio', 'length', 'max'=>6),
			array('used_email, arrived_email', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, medio, sales_agent_id, used_email, arrived_email, reservation_channel_id,customer_reservation_id', 'safe', 'on'=>'search'),
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
			'salesAgent' => array(self::BELONGS_TO, 'SalesAgents', 'sales_agent_id'),
			'reservationChannel' => array(self::BELONGS_TO, 'ReservationChannel', 'reservation_channel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'medio' => Yii::t('mx','Medio'),
			'sales_agent_id' =>Yii::t('mx','Sales Agent'),
			'used_email' =>Yii::t('mx','Used Email'),
			'arrived_email' =>Yii::t('mx','Arrived Email'),
			'reservation_channel_id' =>Yii::t('mx','Reservation Channel'),
            'customer_reservation_id'=>Yii::t('mx','Customer Reservation'),
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
		$criteria->compare('medio',$this->medio,true);
		$criteria->compare('sales_agent_id',$this->sales_agent_id);
		$criteria->compare('used_email',$this->used_email,true);
		$criteria->compare('arrived_email',$this->arrived_email,true);
		$criteria->compare('reservation_channel_id',$this->reservation_channel_id);
        $criteria->compare('customer_reservation_id',$this->customer_reservation_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Poll the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function listMedia(){

        return array(
            'PHONE'=>Yii::t('mx','PHONE'),
            'EMAIL'=>Yii::t('mx','EMAIL'),
            'OFFICE'=>Yii::t('mx','OFFICE'),
        );

    }

    public function listEmail(){

        return array(
            'cocoaventura@gmail.com'=>'cocoaventura@gmail.com',
            'eventoscocoaventura@gmail.com'=>'eventoscocoaventura@gmail.com'
        );

    }

    public function getForm()
    {
        return array(
            'title' => Yii::t('mx','How we contact the customer?'),
            'showErrorSummary' => true,
            'elements' => array(

                'medio'=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-large',
                    'items'=>$this->listMedia(),
                    'prompt'=>Yii::t('mx','Select'),
                    'onchange'=>'

                        var medio=$(this).val();

                        if(medio=="PHONE" || medio=="OFFICE"){

                        $(".agents").show();
                        $(".usedEmail").show();
                        $(".arrivedEmail").hide();
                        $(".reservationChannel").hide();

                        }else{

                            $(".arrivedEmail").show();
                            $(".reservationChannel").show();
                            $(".agents").hide();
                            $(".usedEmail").hide();

                        }

                    ',
                ),
                'sales_agent_id'=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-large',
                    'items'=>SalesAgents::model()->listSalesAgents(),
                    'prompt'=>Yii::t('mx','Select'),
                ),
                'used_email'=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-large',
                    'items'=>$this->listEmail(),
                    'prompt'=>Yii::t('mx','Select'),
                ),
                'arrived_email'=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-large',
                    'items'=>$this->listEmail(),
                    'prompt'=>Yii::t('mx','Select'),
                ),
                'reservation_channel_id'=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-large',
                    'items'=>ReservationChannel::model()->listReservationChannel(),
                    'prompt'=>Yii::t('mx','Select'),
                ),

            ),

            'buttons' => array(

                'save' => array(
                    'type' => 'ajaxSubmit',
                    'label' => Yii::t('mx','Save'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-ok',
                    'url'=>Yii::app()->createUrl('/poll/create'),
                    'ajaxOptions' => array(
                        'type'=>'POST',
                        'dataType'=>'json',
                        'beforeSend' => 'function() {
                            $("#pollSending").addClass("sending");
                         }',
                        'complete' => 'function() {
                             $("#pollSending").removeClass("sending");
                        }',
                        'success' =>'function(data){

                                var request=data.ok;
                                if(request==true){
                                    document.location.href=data.redirect;
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
