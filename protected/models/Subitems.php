<?php

/**
 * This is the model class for table "subitems".
 *
 * The followings are the available columns in table 'subitems':
 * @property integer $id
 * @property integer $article_id
 * @property integer $unit_measure_id
 * @property string $code
 * @property string $code_store
 * @property string $code_invoice
 * @property string $measure
 * @property string $price
 * @property string $price_kg
 * @property string $date_price
 * @property string $color
 * @property string $presentation
 * @property integer $quantity
 * @property string $conversion_unit
 * @property string $unit_price
 * @property string $explanation
 * @property string $notes
 * @property string $image
 * @property string $barcode
 * @property integer $rating
 */
class Subitems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subitems';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_id, unit_measure_id', 'required'),
			array('article_id, unit_measure_id, quantity, rating', 'numerical', 'integerOnly'=>true),
			array('code, code_store, code_invoice', 'length', 'max'=>20),
			array('measure, color, presentation, conversion_unit, barcode', 'length', 'max'=>50),
			array('price, price_kg, unit_price', 'length', 'max'=>10),
			array('image', 'length', 'max'=>100),
			array('date_price, explanation, notes', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, article_id, unit_measure_id, code, code_store, code_invoice, measure, price, price_kg, date_price, color, presentation, quantity, conversion_unit, unit_price, explanation, notes, image, barcode, rating', 'safe', 'on'=>'search'),
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
            'unitmeasure' => array(self::BELONGS_TO, 'UnitsMeasurement', 'unit_measure_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'article_id' => Yii::t('mx','Article'),
			'unit_measure_id' => Yii::t('mx','Unit Of Measure'),
			'code' => Yii::t('mx','Code'),
			'code_store' => Yii::t('mx','Code Store'),
			'code_invoice' => Yii::t('mx','Code Invoice'),
			'measure' => Yii::t('mx','Measure'),
			'price' => Yii::t('mx','Price'),
			'price_kg' => Yii::t('mx','Price X Kg'),
			'date_price' => Yii::t('mx','Date'),
			'color' => Yii::t('mx','Color'),
			'presentation' => Yii::t('mx','Presentation'),
			'quantity' => Yii::t('mx','Quantity'),
			'conversion_unit' => Yii::t('mx','Conversion Unit'),
			'unit_price' => Yii::t('mx','Unit Price'),
			'explanation' => Yii::t('mx','Explanation'),
			'notes' => Yii::t('mx','Notes'),
			'image' => Yii::t('mx','Image'),
			'barcode' => Yii::t('mx','Barcode'),
			'rating' => Yii::t('mx','Rating'),
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
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('unit_measure_id',$this->unit_measure_id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('code_store',$this->code_store,true);
		$criteria->compare('code_invoice',$this->code_invoice,true);
		$criteria->compare('measure',$this->measure,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('price_kg',$this->price_kg,true);
		$criteria->compare('date_price',$this->date_price,true);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('presentation',$this->presentation,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('conversion_unit',$this->conversion_unit,true);
		$criteria->compare('unit_price',$this->unit_price,true);
		$criteria->compare('explanation',$this->explanation,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('barcode',$this->barcode,true);
		$criteria->compare('rating',$this->rating);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function getForm(){

       return array(

               'elements'=>array(

                   'image'=>array(
                       'type'=>'file',
                   ),
                   /*'unit_measure_id'=>array(
                       'type'=>'select2',
                       'data'=>UnitsMeasurement::model()->listAll(),
                       'prompt'=>Yii::t('mx','Select'),
                   ),*/

                   'code'=>array(
                       'type'=>'text',
                   ),
                   'code_store'=>array(
                       'type'=>'text',
                   ),
                   'code_invoice'=>array(
                       'type'=>'text',
                   ),
                   'measure'=>array(
                       'type'=>'text',
                   ),
                   'price'=>array(
                       'type'=>'text',
                   ),
                   'price_kg'=>array(
                       'type'=>'text',
                   ),
                   'date_price' => array(
                       'type'=>'zii.widgets.jui.CJuiDatePicker',
                       'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                       'options'=>array(
                           'showAnim'=>'slide',
                           'changeYear' => true,
                           'changeMonth' => true,
                           'dateFormat'=>Yii::app()->format->dateFormat,

                       ),
                       'htmlOptions' => array(
                           'class' => 'input-medium',
                       ),
                   ),
               ));
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
