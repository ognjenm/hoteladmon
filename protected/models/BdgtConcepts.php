<?php

/**
 * This is the model class for table "bdgt_concepts".
 *
 * The followings are the available columns in table 'bdgt_concepts':
 * @property integer $id
 * @property integer $bdgt_group_id
 * @property string $concept
 * @property string $description
 * @property string $description_suppliers
 * @property string $price
 * @property string $supplier_price
 *
 * The followings are the available model relations:
 * @property BdgtGroups $bdgtGroup
 */
class BdgtConcepts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bdgt_concepts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bdgt_group_id, concept, price', 'required'),
			array('bdgt_group_id', 'numerical', 'integerOnly'=>true),
			array('concept', 'length', 'max'=>500),
			array('price, supplier_price', 'length', 'max'=>10),
			array('description, description_suppliers', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bdgt_group_id, concept, description, description_suppliers, price, supplier_price', 'safe', 'on'=>'search'),
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
			'bdgtGroup' => array(self::BELONGS_TO, 'BdgtGroups', 'bdgt_group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'bdgt_group_id' => Yii::t('mx','Group'),
            'concept' => Yii::t('mx','Concept'),
            'description' => Yii::t('mx','Description'),
            'description_suppliers' => Yii::t('mx','Description Of Supliers'),
            'price' => Yii::t('mx','Price'),
            'supplier_price' => Yii::t('mx','Supplier Price'),


		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('bdgt_group_id',$this->bdgt_group_id);
		$criteria->compare('concept',$this->concept,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('description_suppliers',$this->description_suppliers,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('supplier_price',$this->supplier_price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function popover($description){

        $popover=Yii::t('mx','Not set');

        if($description!=null){

            $popover='<p class="popover-examples">';
            $popover.='<a href="#"';
            $popover.='" class="" data-toggle="popover"';
            $popover.=' data-title="';
            $popover.='<h4>'.Yii::t('mx','Description').'</h4>';
            $popover.='"';
            $popover.=' data-content="';
            $popover.='</p>'.$description.'</p>';
            $popover.='">';
            $popover.='<i class="icon-comment icon-2x"></i>';
            $popover.='</a>';
            $popover.='</p>';
        }


        return $popover;

    }

    public function listAll(){
        return CHtml::listData($this->model()->findAll(array('order'=>'concept')),'id','concept');
    }


    public static function getSubtotal($conceptId,$pax){

        $price=0;
        $concepts=BdgtConcepts::model()->findByPk($conceptId);

        if($concepts){
            $price=$concepts->price*$pax;
        }

        return $price;

    }

    public static function getPricexPax($conceptId){

        $concept=BdgtConcepts::model()->findByPk($conceptId);

        if($concept) return $concept->price;
        else return 0;

    }

    public static function getPriceProviderxPax($conceptId){

        $concept=BdgtConcepts::model()->findByPk($conceptId);

        if($concept) return $concept->supplier_price;
        else return 0;
    }

    public static function FindByGroup($groupId){

        $list=array();

        $options=BdgtConcepts::model()->findAll(array(
            'condition'=>'bdgt_group_id=:groupId',
            'params'=>array('groupId'=>$groupId)
        ));

        if($options) $list=CHtml::listData($options,'id','concept');

        return $list;

    }

    public function beforeSave(){

        $price=(string)$this->price;
        $price=str_replace(',','',$price);
        $this->price=$price;

        $supplier_price=(string)$this->supplier_price;
        $supplier_price=str_replace(',','',$supplier_price);
        $this->supplier_price=$supplier_price;

        return parent::beforeSave();

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
