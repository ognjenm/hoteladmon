<?php

/**
 * This is the model class for table "bdgt_concepts".
 *
 * The followings are the available columns in table 'bdgt_concepts':
 * @property integer $id
 * @property integer $bdgt_group_id
 * @property string $concept
 * @property string $description
 * @property string $price
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
			array('bdgt_group_id', 'required'),
			array('bdgt_group_id', 'numerical', 'integerOnly'=>true),
			array('concept', 'length', 'max'=>500),
			array('price', 'length', 'max'=>10),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bdgt_group_id, concept, description, price', 'safe', 'on'=>'search'),
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
			'price' => Yii::t('mx','Price'),
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
		$criteria->compare('bdgt_group_id',$this->bdgt_group_id);
		$criteria->compare('concept',$this->concept,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('price',$this->price,true);

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
