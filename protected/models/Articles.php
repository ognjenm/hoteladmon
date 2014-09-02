<?php

class Articles extends CActiveRecord
{
    public $names;

	public function tableName()
	{
		return 'articles';
	}


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
			array('provider_id, name_article, unit_measure_id, measure, price, presentation, names', 'safe', 'on'=>'search'),

            array('image', 'file',
                'allowEmpty'=>'true',
                'types'=>'jpg, gif, png',
                'maxSize'=>1024 * 1024 * 2, // 500Kb
                'tooLarge'=>'The image was larger than 500Kb. Please upload a smaller image.',
            ),

            /*array('image', 'ImageValidator',
                'allowEmpty'=>'true',
                'width' => 300,
                'height' => 200
            ),*/

        );
	}


	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'provider' => array(self::BELONGS_TO, 'Providers', 'provider_id'),
            'unitmeasure' => array(self::BELONGS_TO, 'UnitsMeasurement', 'unit_measure_id'),
		);
	}


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
            'names'=>  Yii::t('mx','Behalf of us').', '.Yii::t('mx','Name Store').', '.Yii::t('mx','Name Invoice')
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

        if(isset($_GET['Articles']['names'])){
            $criteria->condition = 'match(name_article,name_store,name_invoice) against(:busqueda in boolean mode)';
            $criteria->params = array(':busqueda'=>'"'.$_GET['Articles']['names'].'"');
        }

		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('name_article',$this->name_article,true);
		$criteria->compare('unit_measure_id',$this->unit_measure_id);
		$criteria->compare('measure',$this->measure,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('presentation',$this->presentation,true);


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            )
        ));
	}

    public function getFormFilter(){

        return array(
            'id'=>'filterForm',
            //'title'=>Yii::t('mx','Search Criteria'),
            'elements'=>array(
                "names"=>array(
                    'label'=>Yii::t('mx','Search'),
                    'type' => 'text',
                    'class'=>'span5 '
                ),

            ),
            'buttons' => array(
                'filter' => array(
                    'type' => 'submit',
                    'label' => Yii::t('mx','Ok'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-search',
                    'url'=>Yii::app()->createUrl('/articles/index'),
                ),
            )
        );
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
