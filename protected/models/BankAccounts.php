<?php

/**
 * This is the model class for table "bank_accounts".
 *
 * The followings are the available columns in table 'bank_accounts':
 * @property integer $id
 * @property string $account_name
 * @property integer $bank_id
 * @property integer $account_type_id
 * @property string $account_number
 * @property string $clabe
 * @property string $initial_balance
 * @property integer $cheq_num_start
 * @property integer $cheq_num_end
 * @property integer $consecutive
 */
class BankAccounts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bank_accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bank_id, account_type_id', 'required'),
			array('bank_id, account_type_id, cheq_num_start, cheq_num_end, consecutive', 'numerical', 'integerOnly'=>true),
			array('account_name', 'length', 'max'=>500),
			array('account_number', 'length', 'max'=>100),
			array('clabe', 'length', 'max'=>50),
			array('initial_balance', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_name, bank_id, account_type_id, account_number, clabe, initial_balance, cheq_num_start, cheq_num_end, consecutive', 'safe', 'on'=>'search'),
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
            'payments' => array(self::HAS_MANY, 'Payments', 'bank_id'),
            'accountType' => array(self::BELONGS_TO, 'AccountTypes', 'account_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'account_name' => Yii::t('mx','Account Name'),
			'bank_id' => Yii::t('mx','Bank'),
			'account_type_id' => Yii::t('mx','Account Type'),
			'account_number' => Yii::t('mx','Account Number'),
			'clabe' => Yii::t('mx','Clabe'),
			'initial_balance' => Yii::t('mx','Initial Balance'),
            'cheq_num_start' => Yii::t('mx','Initial number of checkbook'),
            'cheq_num_end' => Yii::t('mx','Final number of checkbook'),
			'consecutive' => Yii::t('mx','Consecutive'),
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('account_name',$this->account_name,true);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('account_type_id',$this->account_type_id);
		$criteria->compare('account_number',$this->account_number,true);
		$criteria->compare('clabe',$this->clabe,true);
		$criteria->compare('initial_balance',$this->initial_balance,true);
		$criteria->compare('cheq_num_start',$this->cheq_num_start);
		$criteria->compare('cheq_num_end',$this->cheq_num_end);
		$criteria->compare('consecutive',$this->consecutive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



    public function listAll(){
        $lista=array();
        $result=$this->model()->findAll(array('order'=>'id'));

        foreach($result as $item){
            $lista[$item->id]=$item->bank->bank." - ".substr($item->account_number,-4);
        }

        if($lista !=null) return $lista;
        else return array('prompt'=>Yii::t('mx','Select'));

    }

    public function accountByPk($id){

        $account=$this->findByPk($id);
        return $account->bank->bank.'-'.substr($account->account_number,-4);

    }

    public function numerosCheque($accountId){

        $account=$this::model()->findByPk($accountId);
        $cheques=$account->cheq_num_end-$account->consecutive;

        return $cheques;

    }

    public function consultConsecutiveCheque($accountId){

        $consecutive=0;

        $account=$this::model()->findByPk($accountId);

        if($account){
            $consecutive=$account->consecutive+1;
        }

        return $consecutive;

    }

    public function consultRetirement($accountId,$retirement){

        $balance=0;

        $account=$this::model()->findByPk($accountId);

        if($account){
            $balance=$account->initial_balance-$retirement;
        }

        return $balance;

    }

    public function consultDeposit($accountId,$deposit){

        $balance=0;

        $account=$this::model()->findByPk($accountId);

        if($account){
            $balance=$account->initial_balance+$deposit;
        }

        return $balance;

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
