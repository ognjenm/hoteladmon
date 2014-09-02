<?php

/**
 * This is the model class for table "invoices".
 *
 * The followings are the available columns in table 'invoices':
 * @property integer $id
 * @property integer $provider_id
 * @property integer $tax_information_id
 * @property string $date_expedition
 * @property string $subtotal
 * @property string $tax
 * @property string $total
 * @property integer $isclose
 * @property integer $currency_id
 * @property integer $payment_method_id
 * @property integer $payment_terms_id
 * @property string $tax_lodging
 * @property integer $bill_to
 *
 * The followings are the available model relations:
 * @property ItemsInvoice[] $itemsInvoices
 */
class Invoices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('provider_id, tax_information_id, isclose, currency_id, payment_method_id, payment_terms_id, bill_to', 'numerical', 'integerOnly'=>true),
			array('subtotal, tax, total, tax_lodging', 'length', 'max'=>10),
			array('date_expedition', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, provider_id, tax_information_id, date_expedition, subtotal, tax, total, isclose, currency_id, payment_method_id, payment_terms_id, tax_lodging, bill_to', 'safe', 'on'=>'search'),
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
			'itemsInvoices' => array(self::HAS_MANY, 'ItemsInvoice', 'invoice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'provider_id' => 'Provider',
			'tax_information_id' => 'Tax Information',
			'date_expedition' => 'Date Expedition',
			'subtotal' => 'Subtotal',
			'tax' => 'Tax',
			'total' => 'Total',
			'isclose' => 'Isclose',
			'currency_id' => 'Currency',
			'payment_method_id' => 'Payment Method',
			'payment_terms_id' => 'Payment Terms',
			'tax_lodging' => 'Tax Lodging',
			'bill_to' => Yii::t('mx','Bill To'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('tax_information_id',$this->tax_information_id);
		$criteria->compare('date_expedition',$this->date_expedition,true);
		$criteria->compare('subtotal',$this->subtotal,true);
		$criteria->compare('tax',$this->tax,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('isclose',$this->isclose);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('payment_method_id',$this->payment_method_id);
		$criteria->compare('payment_terms_id',$this->payment_terms_id);
		$criteria->compare('tax_lodging',$this->tax_lodging,true);
		$criteria->compare('bill_to',$this->bill_to);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Invoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
