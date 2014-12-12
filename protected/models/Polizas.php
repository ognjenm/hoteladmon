<?php


class Polizas extends CActiveRecord
{
    public $date;
    public $bank;
    public $cheq;
    public $released;
    public $retirement;
    public $total_bill;
    public $invoices;

	public function tableName()
	{
		return 'polizas';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operation_id, invoice_ids, user_id', 'required'),
			array('operation_id, user_id, authorized_by, payment_type, for_beneficiary_account, has_bill', 'numerical', 'integerOnly'=>true),
			array('invoice_ids', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, operation_id, invoice_ids, user_id, authorized_by, payment_type, for_beneficiary_account, has_bill', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{

		return array(
            'operations' => array(self::BELONGS_TO, 'Operations', 'operation_id'),
            'accountDebit' => array(self::BELONGS_TO, 'DebitOperations', 'operation_id'),
            'accountCredit' => array(self::BELONGS_TO, 'CreditOperations', 'operation_id'),
            'user'=>array(self::BELONGS_TO, 'CrugeUser1', 'user_id'),
            'authorized'=>array(self::BELONGS_TO, 'AuthorizingPersons', 'authorized_by'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'operation_id' => 'Operation',
            'invoice_ids' => 'Invoices',
            'date'=>Yii::t('mx','Date'),
            'bank'=>Yii::t('mx','Bank'),
            'cheq'=>Yii::t('mx','Cheq'),
            'released'=>Yii::t('mx','Released'),
            'retirement'=>Yii::t('mx','Retirement'),
            'user_id' => Yii::t('mx','User'),
            'authorized_by' => Yii::t('mx','Authorized by'),
            'payment_type' => Yii::t('mx','Payment Type'),
            'for_beneficiary_account' => Yii::t('mx','For credit to the beneficiary account'),
			'has_bill' => Yii::t('mx','Has Bill'),
            'total_bill'=>Yii::t('mx','Total Invoiced'),
            'invoices'=>Yii::t('mx','Invoices')
		);
	}

    public function search()
    {

        $criteria=new CDbCriteria;

        $criteria->with = array(
            'operations' => array(
                'joinType' => 'INNER JOIN',
            ),
        );

        $criteria->compare('operations.bank_id',$this->bank,true);
        $criteria->compare('operations.cheq',$this->cheq,true);
        $criteria->compare('operations.released',$this->released,true);
        $criteria->compare('operations.retirement',$this->retirement,true);


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'operations.datex DESC',
                'attributes'=>array(
                    'date'=>array(
                        'asc'=>'operations.datex',
                        'desc'=>'operations.datex desc',
                    ),
                    'bank'=>array(
                        'asc'=>'operations.bank_id',
                        'desc'=>'operations.bank_id desc',
                    ),
                    'cheq'=>array(
                        'asc'=>'operations.cheq',
                        'desc'=>'operations.cheq desc',
                    ),
                    'released'=>array(
                        'asc'=>'operations.released',
                        'desc'=>'operations.released desc',
                    ),
                    'retirement'=>array(
                        'asc'=>'operations.retirement',
                        'desc'=>'operations.retirement desc',
                    ),
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
    }

    public function getNumInvoices($id){

        $lista=$this::model()->findByPk((int)$id);
        $invoices=0;
        $ids=array_filter(explode(',',$lista->invoice_ids));

        if(!empty($ids)) $invoices= count($ids);

        return $invoices;

    }

    public function getPending() {

        $statuscolor='white';

        switch ($this->has_bill) {
            case 0:
                $statuscolor='warning';
                break;
        }

        return $statuscolor;

    }

    public function searchInvoiceDiference(){

        $criteria=new CDbCriteria;

        $criteria->with = array(
            'operations' => array(
                'joinType' => 'INNER JOIN',
            ),
        );

        $criteria->compare('operations.bank_id',$this->bank,true);
        $criteria->compare('operations.cheq',$this->cheq,true);
        $criteria->compare('operations.released',$this->released,true);
        $criteria->compare('operations.retirement',$this->retirement,true);
        $criteria->compare('has_bill',1);


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'operations.datex DESC',
                'attributes'=>array(
                    'date'=>array(
                        'asc'=>'operations.datex',
                        'desc'=>'operations.datex desc',
                    ),
                    'bank'=>array(
                        'asc'=>'operations.bank_id',
                        'desc'=>'operations.bank_id desc',
                    ),
                    'cheq'=>array(
                        'asc'=>'operations.cheq',
                        'desc'=>'operations.cheq desc',
                    ),
                    'released'=>array(
                        'asc'=>'operations.released',
                        'desc'=>'operations.released desc',
                    ),
                    'retirement'=>array(
                        'asc'=>'operations.retirement',
                        'desc'=>'operations.retirement desc',
                    ),
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
    }

    public function searchNoBill()
    {

        $criteria=new CDbCriteria;

        $criteria->with = array(
            'operations' => array(
                'joinType' => 'INNER JOIN',
            ),
        );

        $criteria->compare('operations.bank_id',$this->bank,true);
        $criteria->compare('operations.cheq',$this->cheq,true);
        $criteria->compare('operations.released',$this->released,true);
        $criteria->compare('operations.retirement',$this->retirement,true);
        $criteria->compare('has_bill',0);


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'operations.datex DESC',
                'attributes'=>array(
                    'date'=>array(
                        'asc'=>'operations.datex',
                        'desc'=>'operations.datex desc',
                    ),
                    'bank'=>array(
                        'asc'=>'operations.bank_id',
                        'desc'=>'operations.bank_id desc',
                    ),
                    'cheq'=>array(
                        'asc'=>'operations.cheq',
                        'desc'=>'operations.cheq desc',
                    ),
                    'released'=>array(
                        'asc'=>'operations.released',
                        'desc'=>'operations.released desc',
                    ),
                    'retirement'=>array(
                        'asc'=>'operations.retirement',
                        'desc'=>'operations.retirement desc',
                    ),
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
    }

    public function accountDebit()
    {

        $criteria=new CDbCriteria;

        $criteria->with = array(
            'accountDebit' => array(
                'joinType' => 'INNER JOIN',
                //'condition'=>'accountDebit.payment_type=4'
            ),
        );

        $criteria->compare('accountDebit.bank_id',$this->bank,true);
        $criteria->compare('accountDebit.cheq',$this->cheq,true);
        $criteria->compare('accountDebit.released',$this->released,true);
        $criteria->compare('accountDebit.retirement',$this->retirement,true);
        $criteria->compare('t.payment_type',4);


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'accountDebit.datex DESC',
                'attributes'=>array(
                    'date'=>array(
                        'asc'=>'accountDebit.datex',
                        'desc'=>'accountDebit.datex desc',
                    ),
                    'bank'=>array(
                        'asc'=>'accountDebit.bank_id',
                        'desc'=>'accountDebit.bank_id desc',
                    ),
                    'cheq'=>array(
                        'asc'=>'accountDebit.cheq',
                        'desc'=>'accountDebit.cheq desc',
                    ),
                    'released'=>array(
                        'asc'=>'accountDebit.released',
                        'desc'=>'accountDebit.released desc',
                    ),
                    'retirement'=>array(
                        'asc'=>'accountDebit.retirement',
                        'desc'=>'accountDebit.retirement desc',
                    ),
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
    }

    public function accountCredit()
    {

        $criteria=new CDbCriteria;

        $criteria->with = array(
            'accountCredit' => array(
                'joinType' => 'INNER JOIN',
            ),
        );

        $criteria->compare('accountCredit.bank_id',$this->bank,true);
        $criteria->compare('accountCredit.cheq',$this->cheq,true);
        $criteria->compare('accountCredit.released',$this->released,true);
        $criteria->compare('accountCredit.retirement',$this->retirement,true);
        $criteria->compare('t.payment_type',6);


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'accountCredit.datex DESC',
                'attributes'=>array(
                    'date'=>array(
                        'asc'=>'accountCredit.datex',
                        'desc'=>'accountCredit.datex desc',
                    ),
                    'bank'=>array(
                        'asc'=>'accountCredit.bank_id',
                        'desc'=>'accountCredit.bank_id desc',
                    ),
                    'cheq'=>array(
                        'asc'=>'accountCredit.cheq',
                        'desc'=>'accountCredit.cheq desc',
                    ),
                    'released'=>array(
                        'asc'=>'accountCredit.released',
                        'desc'=>'accountCredit.released desc',
                    ),
                    'retirement'=>array(
                        'asc'=>'accountCredit.retirement',
                        'desc'=>'accountCredit.retirement desc',
                    ),
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
