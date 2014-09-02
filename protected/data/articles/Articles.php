<?php

/**
 * This is the model class for table "articles".
 *
 * The followings are the available columns in table 'articles':
 * @property integer $id
 * @property integer $provider_id
 * @property string $name_article
 * @property string $name_store
 * @property string $name_invoice
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
class Articles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'articles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('provider_id, unit_measure_id', 'required'),
			array('provider_id, unit_measure_id, quantity, rating', 'numerical', 'integerOnly'=>true),
			array('name_article, name_store, name_invoice', 'length', 'max'=>100),
			array('code, code_store, code_invoice', 'length', 'max'=>20),
			array('measure, color, conversion_unit, barcode', 'length', 'max'=>50),
			array('price, price_kg, unit_price', 'length', 'max'=>10),
			array('presentation', 'length', 'max'=>150),
			array('date_price, explanation, notes', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, image, provider_id, name_article, name_store, name_invoice, unit_measure_id, code, code_store, code_invoice, measure, price, price_kg, date_price, color, presentation, quantity, conversion_unit, unit_price, explanation, notes, image, barcode, rating', 'safe', 'on'=>'search'),

            array('image', 'file',
                'allowEmpty'=>'true',
                'types'=>'jpg, gif, png',
                'maxSize'=>1024 *  500, // 500Kb
                'tooLarge'=>'The image was larger than 500Kb. Please upload a smaller image.',
            ),

            /*array('image', 'ImageValidator',
                'allowEmpty'=>'true',
                'width' => 620,
                'height' => 460
            ),*/

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
            'provider_id' => Yii::t('mx','Provider'),
            'name_article' => Yii::t('mx','Behalf of us'),
            'name_store' => Yii::t('mx','Name Store'),
            'name_invoice' => Yii::t('mx','Name Invoice'),
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
		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('name_article',$this->name_article,true);
		$criteria->compare('name_store',$this->name_store,true);
		$criteria->compare('name_invoice',$this->name_invoice,true);
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
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            )
        ));
	}

    public function beforeSave(){

        $date_price=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->date_price);
        $this->date_price=date("Y-m-d",strtotime($date_price));

        return parent::beforeSave();

    }

    public function afterFind() {

        $this->date_price=date("d-M-Y",strtotime($this->date_price));
        return  parent::afterFind();
    }

    public function listAll(){

        $lista=array();
        $result=$this->model()->findAll(array('order'=>'name_article'));

        foreach($result as $item){
            $lista[$item->id]=$item->name_article.' - '.$item->unitmeasure->unit.' - '.$item->measure.' - '.$item->presentation;
        }

        if($lista !=null) return $lista;
        else return array('prompt'=>Yii::t('mx','Select'));

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
