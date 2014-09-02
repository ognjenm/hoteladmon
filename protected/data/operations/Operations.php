<?php

/**
 * This is the model class for table "operations".
 *
 * The followings are the available columns in table 'operations':
 * @property integer $id
 * @property integer $payment_type
 * @property integer $bank_id
 * @property string $cheq
 * @property string $datex
 * @property string $released
 * @property string $concept
 * @property string $person
 * @property string $bank_concept
 * @property string $retirement
 * @property string $deposit
 * @property string $balance
 * @property integer $iscancelled
 */
class Operations extends CActiveRecord
{
    public $inicio;
    public $fin;
    public $authorized;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_type, bank_id, iscancelled', 'numerical', 'integerOnly'=>true),
			array('cheq', 'length', 'max'=>30),
			array('released, concept, person, bank_concept', 'length', 'max'=>100),
			array('retirement, deposit, balance,inicio,fin', 'length', 'max'=>10),
			array('datex', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, payment_type, bank_id, cheq, datex, released, concept, person, bank_concept, retirement, deposit, balance, iscancelled,inicio,fin', 'safe', 'on'=>'search'),
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
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'payment_type' => Yii::t('mx','Payment Type'),
            'bank_id' => Yii::t('mx','Account'),
            'cheq' => Yii::t('mx','Cheq'),
            'datex' => Yii::t('mx','Date'),
            'released' => Yii::t('mx','Rid To'),
            'concept' => Yii::t('mx','Concept'),
            'person' => Yii::t('mx','Person'),
            'bank_concept' => Yii::t('mx','Bank Concept'),
            'retirement' => Yii::t('mx','Retirement'),
            'deposit' => Yii::t('mx','Deposit'),
            'balance' => Yii::t('mx','Balance'),
			'iscancelled' => 'Iscancelled',
            'inicio'=>'',
            'fin'=>'',
            'authorized'=>Yii::t('mx','Authorized by'),
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('payment_type',$this->payment_type);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('cheq',$this->cheq,true);
		$criteria->compare('datex',$this->datex,true);
		$criteria->compare('released',$this->released,true);
		$criteria->compare('concept',$this->concept,true);
		$criteria->compare('person',$this->person,true);
		$criteria->compare('bank_concept',$this->bank_concept,true);
		$criteria->compare('retirement',$this->retirement,true);
		$criteria->compare('deposit',$this->deposit,true);
		$criteria->compare('balance',$this->balance,true);
		$criteria->compare('iscancelled',$this->iscancelled);
        $criteria->compare('datex','>='.$this->inicio,true);
        $criteria->compare('datex','<='.$this->fin,true);

        $criteria->order = 'datex ASC';

        return new CActiveDataProvider($this, array(
            'keyAttribute'=>'id',
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
		));
	}

    public function getFormFilter(){

        $fecha = new DateTime();
        $fecha->modify('first day of this month');

        return array(
            'id'=>'filterForm',
            'title'=>Yii::t('mx','Criteria'),
            'elements'=>array(

                "bank_id"=>array(
                    'label'=>Yii::t('mx','Bank'),
                    'type' => 'dropdownlist',
                    'items'=>Banks::model()->listAllBanks(),
                    'prompt'=>Yii::t('mx','Select'),
                ),

                "inicio"=>array(
                    'type' => 'date',
                    'value'=>  $fecha->format('Y-m-d'),
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'options'=>array('format'=>'yyyy-mm-dd'),
                ),
                "fin"=>array(
                    'type' => 'date',
                    'value'=>date('Y-m-d'),
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'options'=>array('format'=>'yyyy-mm-dd'),
                ),
            ),
            'buttons' => array(
                'filter' => array(
                    'type' => 'submit',
                    'label' => Yii::t('mx','Filter'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-filter',
                    'url'=>Yii::app()->createUrl('/operations/index'),
                ),
                'reset' => array(
                    'type' => 'reset',
                    'label' => Yii::t('mx','Reset'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-remove',
                    'url'=>Yii::app()->createUrl('/operations/index'),
                    'htmlOptions'=>array(
                        'onclick'=>'
                            $("#div-grid-operations").hide();
                        '
                    )
                ),
            )
        );
    }

    public function getForm(){

        return array(
            'id'=>'operations-form',
            'showErrorSummary' => true,
            'elements'=>array(
                'released'=>array(
                    'type'=>'select2',
                    'data'=>Providers::model()->listAllOrganization(),
                ),
                'bank_id'=>array(
                    'type'=>'dropdownlist',
                    'items'=>Banks::model()->listAllBanks(),
                    'prompt'=>Yii::t('mx','Select'),
                    'onchange'=>'

                            $.ajax({
                                url: "'.CController::createUrl('/authorizingPersons/getAuthorized').'",
                                data: { bankId: $(this).val()  },
                                type: "POST",
                                dataType:"json",
                                beforeSend: function() { $(".modal-body").addClass("loading"); }
                            })

                            .done(function(data) {
                                if(data.ok==true){
                                    $("#Operations_authorized").html(data.authorized);
                                }else{
                                    bootbox.alert(data.msg);
                                }
                            })
                            .fail(function() {  bootbox.alert("error"); })
                            .always(function() { $(".modal-body").removeClass("loading"); });
                    ',
                ),

                'authorized'=>array(
                    'type'=>'dropdownlist',
                    'items'=>array(''=>Yii::t('mx','Select')),
                ),
            ),

            'buttons' => array(
                'budget' => array(
                    'type' => 'button',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Create'),
                    'url'=>Yii::app()->createUrl('/directInvoice/poliza'),
                    'htmlOptions'=>array(
                        'onclick'=>"

                            var invoice=$.fn.yiiGridView.getChecked('direct-invoice-grid','chk').toString();
                            var transporte=$('#Transport-form').serialize();
                            var operations=$('#operations-form').serialize();
                            var dataString=transporte+operations+'&invoice='+invoice;

                             $.ajax({
                                url: '".CController::createUrl('/directInvoice/poliza')."',
                                data: dataString,
                                type: 'POST',
                                dataType: 'json',
                                beforeSend: function() { $('.modal-body').addClass('saving'); }
                            })

                            .done(function(data) {

                                 $('#modal-operations').modal('hide');

                                 $('#direct-invoice-grid').yiiGridView('update', {
                                            data: $(this).serialize()
                                 });

                                 $('#suma').html('');

                                 window.location.href=data.url;

                             })

                            .fail(function() { bootbox.alert('Error');  })
                            .always(function() { $('.modal-body').removeClass('saving'); });

                        "
                    )
                ),

            )
        );
    }


    public function listAll(){
        return CHtml::listData($this->model()->findAll(array('order'=>'deposit')),'id','deposit');
    }


    public function beforeSave(){

        $this->datex=$date= date("Y-m-d",strtotime($this->datex));

        return parent::beforeSave();

    }

    public function afterFind() {
        //        $this->datex=Yii::app()->quoteUtil->toSpanishDate($this->datex);


        $date= date("d-M-Y",strtotime($this->datex));
        $this->datex=$date;

        return  parent::afterFind();
    }

    public function behaviors()
    {
        return array(
            'CustomerAuditBehavior'=> array(
                'class' => 'application.behaviors.OperationsAuditBehavior',
            )
        );

    }



    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
