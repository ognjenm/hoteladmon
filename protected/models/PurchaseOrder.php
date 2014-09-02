<?php

class PurchaseOrder extends CActiveRecord
{
    public $provider_id;
    public $article_id;
    public $address;
    public $logo;
    public $phone;

	public function tableName()
	{
		return 'purchase_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('total', 'length', 'max'=>10),
			array('datex', 'safe'),

			array('id, user_id, datex, total, provider_id, article_id', 'safe', 'on'=>'search'),
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
			'purchaseOrderItems' => array(self::HAS_MANY, 'PurchaseOrderItems', 'purchase_order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => Yii::t('mx','User'),
			'datex' => Yii::t('mx','Date'),
			'total' => Yii::t('mx','Total'),
            'provider_id'=>Yii::t('mx','Provider')
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

        $criteria->with = array(
            'purchaseOrderItems' => array(
                'joinType' => 'INNER JOIN',
            ),
        );

		$criteria->compare('datex',$this->datex,true);
        $criteria->compare('purchaseOrderItems.provider_id',$this->provider_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'datex DESC',
                'attributes'=>array(
                    'provider_id'=>array(
                        'asc'=>'purchaseOrderItems.provider_id',
                        'desc'=>'purchaseOrderItems.provider_id',
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
