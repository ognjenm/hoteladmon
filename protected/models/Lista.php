<?php

/**
 * This is the model class for table "lista".
 *
 * The followings are the available columns in table 'lista':
 * @property integer $id
 * @property string $nombre
 * @property integer $order
 */
class Lista extends CActiveRecord
{
    public $provider_id;
    public $article_id;
    public $quantity;
    public $unit_measure_id;
    public $name_store;
    public $name_invoice;
    public $name_article;
    public $code_store;
    public $code_invoice;
    public $color;
    public $presentation;
    public $price;
    public $total_Price;



	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lista';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('order', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, order', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'order' => 'Oder',
            'provider_id'=>Yii::t('mx','Provider'),
            'article_id'=>Yii::t('mx','Article'),
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('order',$this->order);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Lista the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
