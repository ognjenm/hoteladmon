<?php


class Banks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'banks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bank', 'length', 'max'=>500),
			array('phone, rfc', 'length', 'max'=>50),
			array('international_code', 'length', 'max'=>5),
			array('address', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bank, address, phone, rfc, international_code', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bank' => Yii::t('mx','Bank'),
			'address' => Yii::t('mx','Address'),
			'phone' => Yii::t('mx','Phone'),
			'rfc' => Yii::t('mx','Rfc'),
			'international_code' => Yii::t('mx','International Code'),
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('rfc',$this->rfc,true);
		$criteria->compare('international_code',$this->international_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listAll(){
        $lista=array();
        $result=$this->model()->findAll(array('order'=>'bank'));

        foreach($result as $item){
            $lista[$item->id]=$item->bank;
        }

        if($lista !=null) return $lista;
        else return array('prompt'=>Yii::t('mx','Select'));

    }

    public function showByPk($id){

        $bank=null;

        $result=$this->model()->findByPk($id);
        if($result) $bank=$result->bank;

        return $bank;

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
