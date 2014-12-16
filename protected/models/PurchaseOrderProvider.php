<?php

/**
 * This is the model class for table "purchase_order_provider".
 *
 * The followings are the available columns in table 'purchase_order_provider':
 * @property integer $id
 * @property integer $purchase_order_id
 * @property integer $provider_id
 * @property string $note
 * @property string $total
 */
class PurchaseOrderProvider extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'purchase_order_provider';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_order_id, provider_id', 'required'),
			array('purchase_order_id, provider_id', 'numerical', 'integerOnly'=>true),
			array('total', 'length', 'max'=>10),
			array('note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, purchase_order_id, provider_id, note, total', 'safe', 'on'=>'search'),
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
            'provider' => array(self::BELONGS_TO, 'Providers', 'provider_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'purchase_order_id' => Yii::t('mx','Purchase Order'),
			'provider_id' => Yii::t('mx','Provider'),
			'note' => Yii::t('mx','Note'),
			'total' => Yii::t('mx','Total'),
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('purchase_order_id',$this->purchase_order_id);
		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('total',$this->total,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
