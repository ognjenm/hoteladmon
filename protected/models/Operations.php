<?php

class Operations extends CActiveRecord
{
    public $inicio;
    public $fin;

    public $typeCheq;
    public $account_id2;
    public $authorized;
    public $authorized2;
    public $released2;
    public $concept2;
    public $amount;
    public $abonoencuenta;
    public $abonoencuenta2;


	public function tableName()
	{
		return 'operations';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_type, account_id, iscancelled, baucher, n_operation, n_tarjeta', 'numerical', 'integerOnly'=>true),
			array('cheq', 'length', 'max'=>30),
			array('released, concept, person, bank_concept', 'length', 'max'=>100),
			array('retirement, deposit, balance, vat_commission, commission_fee, charge_bank', 'length', 'max'=>10),
			array('datex', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, payment_type, account_id, cheq, datex, released, concept, person, bank_concept, retirement, deposit, balance, iscancelled, vat_commission, commission_fee, charge_bank, baucher, n_operation, n_tarjeta', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'accountBank' => array(self::BELONGS_TO, 'BankAccounts', 'account_id'),
            'payment' => array(self::BELONGS_TO, 'PaymentsTypes', 'payment_type'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'account_id' => Yii::t('mx','Account'),
            'account_id2' => Yii::t('mx','Account'),
            'payment_type' => Yii::t('mx','Payment Type'),
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
            'typeCheq'=>Yii::t('mx','Payment Type'),
            'abonoencuenta'=>Yii::t('mx','For credit to the beneficiary account'),
            'amount'=>Yii::t('mx','Amount'),
            'vat_commission' => Yii::t('mx','Vat Commission'),
            'commission_fee' => Yii::t('mx','Commission Fee'),
            'charge_bank' => Yii::t('mx','Charge Bank'),
			'baucher' => Yii::t('mx','Voucher'),
			'n_operation' => Yii::t('mx','Number Of Operation'),
			'n_tarjeta' => Yii::t('mx','Card Number'),
		);
	}

    public function search($accountId)
    {

        $criteria=new CDbCriteria;
        $inicio=Yii::app()->getSession()->get('dateStart');
        $fin=Yii::app()->getSession()->get('dateEnd');

        if(empty($inicio) && empty($fin)){
            $this->inicio=Yii::app()->quoteUtil->firstDayThisMonth();
            $this->fin=Yii::app()->quoteUtil->lastDayThisMonth();
        }else{

            $this->inicio=$inicio;
            $this->fin=$fin;
        }


        $criteria->compare('payment_type',$this->payment_type);
        $criteria->compare('account_id',$accountId);
        $criteria->compare('cheq',$this->cheq,true);
        $criteria->compare('datex',$this->datex,true);
        $criteria->compare('released',$this->released,true);
        $criteria->compare('concept',$this->concept,true);
        $criteria->compare('person',$this->person,true);
        $criteria->compare('bank_concept',$this->bank_concept,true);
        $criteria->compare('retirement',$this->retirement,true);
        $criteria->compare('deposit',$this->deposit,true);
        $criteria->compare('balance',$this->balance,true);
        $criteria->compare('datex','>='.$this->inicio,true);
        $criteria->compare('datex','<='.$this->fin,true);
        $criteria->order = 'datex ASC';

        $data= new CActiveDataProvider($this, array(
            'keyAttribute'=>'id',
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));


        Yii::app()->getSession()->add('BalanceToPdf',$data);

        return $data;

    }

    public function getFilter(){

        return array(
            'id'=>'filterForm',
            'title'=>Yii::t('mx','Criteria'),
            'elements'=>array(

                "inicio"=>array(
                    'type' => 'date',
                    'value'=> Yii::app()->quoteUtil->firstDayThisMonth(),
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'options'=>array('format'=>'yyyy-mm-dd','autoclose'=>true),
                ),
                "fin"=>array(
                    'type' => 'date',
                    'value'=> Yii::app()->quoteUtil->lastDayThisMonth(),
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'options'=>array('format'=>'yyyy-mm-dd','autoclose'=>true),
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

    public function getFormNoBill(){

        return array(
            'id'=>'operations-form',
            'showErrorSummary' => true,
            'elements'=>array(
                "typeCheq"=>array(
                    'label'=>Yii::t('mx','Type Check'),
                    'type' => 'select2',
                    'data'=>TypeCheck::model()->listAll(),
                    'onchange'=>'

                            $.ajax({
                                url: "'.CController::createUrl('/bankAccounts/getAccounts').'",
                                data: { paymentMethodId: $(this).val()  },
                                type: "POST",
                                dataType:"json",
                                beforeSend: function() { $(".modal-body").addClass("loading"); }
                            })

                            .done(function(data) {
                                if(data.ok==true){
                                    $("#Operations_account_id").html(data.accounts);
                                }else{
                                    bootbox.alert(data.msg);
                                }
                            })

                            .fail(function() {  bootbox.alert("error"); })
                            .always(function() { $(".modal-body").removeClass("loading"); });
                    ',
                ),
                'account_id'=>array(
                    'type'=>'dropdownlist',
                    'items'=>array(),
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
                'released'=>array(
                    'type'=>'select2',
                    'data'=>Providers::model()->listAllOrganization(),
                    'onchange'=>'

                            $.ajax({
                                url: "'.CController::createUrl('/typeCheck/getTypeCheck').'",
                                data: { providerId: $(this).val()  },
                                type: "POST",
                                dataType:"json",
                                beforeSend: function() { $(".modal-body").addClass("loading"); }
                            })

                            .done(function(data) {
                                if(data.ok==true){
                                    $("#Operations_concept").html(data.concept);
                                }else{
                                    bootbox.alert(data.msg);
                                }
                            })

                            .fail(function() {  bootbox.alert("error"); })
                            .always(function() { $(".modal-body").removeClass("loading"); });
                    ',
                ),
                'concept'=>array(
                    'type'=>'dropdownlist',
                    'items'=>array(''=>Yii::t('mx','Select')),
                ),
                'amount'=>array(
                    'type'=>'text',
                    'prepend'=>'$'
                ),
                'abonoencuenta'=>array(
                    'type'=>'checkbox',
                )
            ),

            'buttons' => array(
                'savepolizaNoBill' => array(
                    'type' => 'button',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Create'),
                    'url'=>Yii::app()->createUrl('/polizas/createPolizaNoBill'),
                    'htmlOptions'=>array(
                        'onclick'=>"

                            var invoice=$.fn.yiiGridView.getChecked('direct-invoice-grid','chk').toString();
                            var transporte=$('#Transport-form').serialize();
                            var operations=$('#operations-form').serialize();
                            var dataString=transporte+operations+'&invoice='+invoice;

                             $.ajax({
                                url: '".CController::createUrl('/polizas/createPolizaNoBill')."',
                                data: dataString,
                                type: 'POST',
                                dataType: 'json',
                                beforeSend: function() { $('.modal-body').addClass('saving'); }
                            })

                            .done(function(data) {

                            if(data.ok==true){
                                $('#modal-operations').modal('hide');

                                 $('#direct-invoice-grid').yiiGridView('update', {
                                            data: $(this).serialize()
                                 });

                                 window.location.href=data.url;

                            }else{
                                     bootbox.alert(data.errors);
                            }



                             })

                            .fail(function() { bootbox.alert('Error');  })
                            .always(function() { $('.modal-body').removeClass('saving'); });

                        "
                    )
                ),
            )
        );
    }

    public function getFormPayment(){
        return array(
            'id'=>'form-payment',
            'showErrorSummary' => true,
            'elements'=>array(
                "datex"=>array(
                    'type' => 'date',
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'options'=>array('format'=>'yyyy-M-dd','autoclose'=>true),
                ),
                'payment_type'=>array(
                    'type'=>'dropdownlist',
                    'items'=>PaymentsTypes::model()->listAll(),
                    'prompt'=>Yii::t('mx','Select'),
                ),
                'account_id'=>array(
                    'type'=>'dropdownlist',
                    'items'=>BankAccounts::model()->listAll(),
                    'prompt'=>Yii::t('mx','Select'),
                ),
                'concept'=>array(
                    'type'=>'text',
                ),
                'deposit'=>array(
                    'type'=>'text',
                    'prepend'=>'$'
                ),
            ),

            'buttons' => array(
                'savePayment' => array(
                    'type' => 'submit',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Save'),
                    'url'=>Yii::app()->createUrl('/reservation/payment'),
                ),
            )
        );
    }

    public function getForm(){

        return array(
            'id'=>'operations-form',
            'showErrorSummary' => true,
            'elements'=>array(
                "typeCheq"=>array(
                    'label'=>Yii::t('mx','Type Check'),
                    'type' => 'select2',
                    'data'=>TypeCheck::model()->listAll(),
                    'onchange'=>'

                            $.ajax({
                                url: "'.CController::createUrl('/bankAccounts/getAccounts').'",
                                data: { paymentMethodId: $(this).val()  },
                                type: "POST",
                                dataType:"json",
                                beforeSend: function() { $(".modal-body").addClass("loading"); }
                            })

                            .done(function(data) {
                                if(data.ok==true){
                                    $("#Operations_account_id").html(data.accounts);
                                }else{
                                    bootbox.alert(data.msg);
                                }
                            })

                            .fail(function() {  bootbox.alert("error"); })
                            .always(function() { $(".modal-body").removeClass("loading"); });
                    ',
                ),
                'account_id'=>array(
                    'type'=>'dropdownlist',
                    'items'=>array(),
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
                'released'=>array(
                    'type'=>'select2',
                    'data'=>Providers::model()->listAllOrganization(),
                    'onchange'=>'

                            $.ajax({
                                url: "'.CController::createUrl('/typeCheck/getTypeCheck').'",
                                data: { providerId: $(this).val()  },
                                type: "POST",
                                dataType:"json",
                                beforeSend: function() { $(".modal-body").addClass("loading"); }
                            })

                            .done(function(data) {
                                if(data.ok==true){
                                    $("#Operations_concept").html(data.concept);
                                }else{
                                    bootbox.alert(data.msg);
                                }
                            })

                            .fail(function() {  bootbox.alert("error"); })
                            .always(function() { $(".modal-body").removeClass("loading"); });
                    ',
                ),
                'concept'=>array(
                    'type'=>'dropdownlist',
                    'items'=>array(''=>Yii::t('mx','Select')),
                ),
                'amount'=>array(
                    'type'=>'text',
                    'prepend'=>'$'
                ),
                'abonoencuenta'=>array(
                    'type'=>'checkbox',
                )
            ),

            'buttons' => array(
                'saveOperation' => array(
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
                'savePolizaNoBill' => array(
                    'type' => 'button',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Create'),
                    'url'=>Yii::app()->createUrl('/polizas/createPolizaNoBill'),
                    'htmlOptions'=>array(
                        'onclick'=>"

                            var invoice=$.fn.yiiGridView.getChecked('direct-invoice-grid','chk').toString();
                            var transporte=$('#Transport-form').serialize();
                            var operations=$('#operations-form').serialize();
                            var dataString=transporte+operations+'&invoice='+invoice;

                             $.ajax({
                                url: '".CController::createUrl('/polizas/createPolizaNoBill')."',
                                data: dataString,
                                type: 'POST',
                                dataType: 'json',
                                beforeSend: function() { $('.modal-body').addClass('saving'); }
                            })

                            .done(function(data) {

                            if(data.ok==true){
                                $('#modal-operations').modal('hide');

                                 $('#direct-invoice-grid').yiiGridView('update', {
                                            data: $(this).serialize()
                                 });

                                 window.location.href=data.url;

                            }else{
                                     bootbox.alert(data.errors);
                            }



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

        $date=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->datex);
        $this->datex=date("Y-m-d",strtotime($date));

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
