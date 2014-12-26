<?php


class CreditOperations extends CActiveRecord
{
    public $inicio;
    public $fin;
    public $authorized;
    public $typeCheq;
    public $abonoencuenta;

	public function tableName()
	{
		return 'credit_operations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
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
            'payment' => array(self::BELONGS_TO, 'PaymentsTypes', 'payment_type'),
            'accountBank' => array(self::BELONGS_TO, 'BankAccounts', 'account_id'),
        );
    }


    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'account_id' => Yii::t('mx','Account'),
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
			'vat_commission' => Yii::t('mx','Vat Commision'),
			'commission_fee' => Yii::t('mx','Commission Fee'),
			'charge_bank' => Yii::t('mx','Charge Bank'),
			'baucher' => Yii::t('mx','Baucher'),
			'n_operation' => Yii::t('mx','Number of operation'),
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
