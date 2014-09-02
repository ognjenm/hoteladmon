<?php

/**
 * This is the model class for table "items_invoice".
 *
 * The followings are the available columns in table 'items_invoice':
 * @property integer $id
 * @property integer $invoice_id
 * @property integer $operation_id
 * @property string $quantity
 * @property string $unit
 * @property string $identification
 * @property string $description
 * @property string $unit_price
 * @property string $import
 *
 * The followings are the available model relations:
 * @property Invoices $invoice
 */
class ItemsInvoice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'items_invoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoice_id, operation_id', 'required'),
			array('invoice_id, operation_id', 'numerical', 'integerOnly'=>true),
			array('quantity, unit_price, import', 'length', 'max'=>10),
			array('unit', 'length', 'max'=>20),
			array('identification', 'length', 'max'=>50),
			array('description', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, invoice_id, operation_id, quantity, unit, identification, description, unit_price, import', 'safe', 'on'=>'search'),
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
			'invoice' => array(self::BELONGS_TO, 'Invoices', 'invoice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invoice_id' => 'Invoice',
			'operation_id' => 'Operation',
			'quantity' => 'Quantity',
			'unit' => 'Unit',
			'identification' => 'Identification',
			'description' => 'Description',
			'unit_price' => 'Unit Price',
			'import' => 'Import',
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
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('operation_id',$this->operation_id);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('identification',$this->identification,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('unit_price',$this->unit_price,true);
		$criteria->compare('import',$this->import,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemsInvoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
