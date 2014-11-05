<?php

/**
 * This is the model class for table "bdgt_groups".
 *
 * The followings are the available columns in table 'bdgt_groups':
 * @property integer $id
 * @property string $group_name
 *
 * The followings are the available model relations:
 * @property BdgtConcepts[] $bdgtConcepts
 */
class BdgtGroups extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bdgt_groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_name', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, group_name', 'safe', 'on'=>'search'),
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
			'bdgtConcepts' => array(self::HAS_MANY, 'BdgtConcepts', 'bdgt_group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'group_name' => Yii::t('mx','Group'),
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('group_name',$this->group_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listAll(){

        return CHtml::listData($this->model()->findAll(array('order'=>'group_name')),'id','group_name');
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
