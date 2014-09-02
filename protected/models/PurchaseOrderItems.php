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

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

		return array(
			array('purchase_order_id, provider_id, article_id', 'required'),
			array('purchase_order_id, provider_id, article_id, quantity', 'numerical', 'integerOnly'=>true),
			array('price, amount', 'length', 'max'=>10),
			array('note', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, purchase_order_id, provider_id, article_id, quantity, price, amount, note', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{

		return array(
            'purchaseOrder' => array(self::BELONGS_TO, 'PurchaseOrder', 'purchase_order_id'),
            'provider' => array(self::BELONGS_TO, 'Providers', 'provider_id'),
            'article' => array(self::BELONGS_TO, 'Articles', 'article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'purchase_order_id' => 'Purchase Order',
			'provider_id' => 'Provider',
			'article_id' => 'Article',
			'quantity' => 'Quantity',
			'price' => 'Price',
			'amount' => 'Amount',
			'note' => 'Note',
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('purchase_order_id',$this->purchase_order_id);
		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
