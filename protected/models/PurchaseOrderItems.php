<?php


class PurchaseOrderItems extends CActiveRecord
{
    public $quantity;
    public $unit_measure_id;
    public $name_store;
    public $name_invoice;
    public $name_article;
    public $code_store;
    public $code_invoice;
    public $color;
    public $presentation;
    public $order;

	public function tableName()
	{
		return 'purchase_order_items';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_order_provider_id, article_id', 'required'),
			array('purchase_order_provider_id, article_id, quantity', 'numerical', 'integerOnly'=>true),
			array('price, amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, purchase_order_provider_id, article_id, quantity, price, amount', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'purchaseOrderProvider' => array(self::BELONGS_TO, 'PurchaseOrderProvider', 'purchase_order_provider_id'),
            'article' => array(self::BELONGS_TO, 'Articles', 'article_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'purchase_order_provider_id' => Yii::t('mx','Purchase Order'),
			'article_id' => Yii::t('mx','Article'),
			'quantity' => Yii::t('mx','Quantity'),
			'price' => Yii::t('mx','Price'),
			'amount' => Yii::t('mx','Amount'),
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('purchase_order_provider_id',$this->purchase_order_provider_id);
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('amount',$this->amount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
