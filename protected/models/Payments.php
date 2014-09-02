<?php

class Payments extends CActiveRecord
{
    public $baucher;
    public $n_operation;
    public $n_tarjeta;


	public function tableName()
	{
		return 'payments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_reservation_id, payment_type, account_id', 'required'),
			array('customer_reservation_id, payment_type, account_id, user_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>10),
			array('docnum', 'length', 'max'=>25),
			array('datex, stampt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_reservation_id, amount, payment_type, docnum, account_id, datex, stampt, user_id', 'safe', 'on'=>'search'),
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
            'bank' => array(self::BELONGS_TO, 'Banks', 'bank_id'),
            'payment' => array(self::BELONGS_TO, 'PaymentsTypes', 'payment_type'),
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
            'amount' => Yii::t('mx','Amount'),
            'payment_type' => Yii::t('mx','Payment Type'),
            'docnum' => Yii::t('mx','Docnum'),
            'account_id' => Yii::t('mx','Account'),
            'datex' => Yii::t('mx','Date'),
            'stampt' => Yii::t('mx','Date And Time Of Registration'),
            'user_id' => Yii::t('mx','User'),
            'baucher' => Yii::t('mx','Voucher'),
            'n_operation' => Yii::t('mx','Number Of Operation'),
            'n_tarjeta' => Yii::t('mx','Card Number'),
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('customer_reservation_id',$this->customer_reservation_id);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('payment_type',$this->payment_type);
		$criteria->compare('docnum',$this->docnum,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('datex',$this->datex,true);
		$criteria->compare('stampt',$this->stampt,true);
		$criteria->compare('user_id',$this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            )
        ));

    }

    public function getPaymentTypes(){
        return array(
            'TRANSFER'=>Yii::t('mx','Transfer'),
            'CHECK'=>Yii::t('mx','Check'),
            'DEPOSIT'=>Yii::t('mx','Deposit'),
        );
    }

    public function getForm($customerId=null){

        return array(
            'id'=>'payments-form',
            //'title' => Yii::t('mx','Payments'),
            'showErrorSummary' => true,
            'elements'=>array(

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
                    'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),
                ),
                'payment_type'=>array(
                    'type'=>'dropdownlist',
                    'items'=>PaymentsTypes::model()->listAll(),
                    'prompt'=>Yii::t('mx','Select')
                ),
                'account_id'=>array(
                    'type'=>'select2',
                    'data'=>BankAccounts::model()->listAll(),
                    'prompt'=>Yii::t('mx','Select'),
                ),
                'baucher'=>array(
                    'type'=>'text',
                    'maxlength'=>10,
                    'prepend'=>'#',
                ),
                'n_operation'=>array(
                    'type'=>'text',
                    'maxlength'=>10,
                    'prepend'=>'#',
                ),
                'n_tarjeta'=>array(
                    'type'=>'text',
                    'maxlength'=>16,
                    'prepend'=>'#',
                ),
                'amount'=>array(
                    'type'=>'text',
                    'maxlength'=>10,
                    'prepend'=>'$',
                ),

            ),

            'buttons' => array(

                'budget' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Save'),
                    'url'=>Yii::app()->createUrl('/payments/create',array('id'=>$customerId)),
                    'ajaxOptions' => array(
                        'type'=>'POST',
                        'dataType'=>'json',
                        'beforeSend' => 'function() {  $("#messages").addClass("saving"); }',
                        'complete' => 'function() { $("#messages").removeClass("saving"); }',
                        'success' =>'function(data){
                            if(data.ok==true){

                                $("#payment-modal").modal("hide");

                                $("#payments-grid").yiiGridView("update", {
                                        data: $(this).serialize()
                                 });
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

    /*public function afterFind(){

        $monto=number_format($this->amount,2);
        $this->amount=$monto;

        return parent::afterFind();

    }*/

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
