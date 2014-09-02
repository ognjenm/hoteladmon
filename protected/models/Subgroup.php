<?php

/**
 * This is the model class for table "subgroup".
 *
 * The followings are the available columns in table 'subgroup':
 * @property integer $id
 * @property integer $group_id
 * @property string $subgroup
 */
class Subgroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subgroup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, subgroup', 'required'),
			array('group_id', 'numerical', 'integerOnly'=>true),
			array('subgroup', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, group_id, subgroup', 'safe', 'on'=>'search'),
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
            'group' => array(self::BELONGS_TO, 'Groups', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'group_id' => Yii::t('mx','Group'),
			'subgroup' => Yii::t('mx','Subgroup'),
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
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('subgroup',$this->subgroup,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listAll(){

        return CHtml::listData($this->model()->findAll(array('order'=>'subgroup')),'id','subgroup','group_id');
    }

    public function listAll2(){
        $groups=array();
        $subgroups=array();
        $groups=Groups::model()->findAll(array('order'=>'name'));

        foreach($groups as $item){

            $subitems=array();
            $sub=Subgroup::model()->findAll(array('condition'=>'group_id=:subgroupId','params'=>array('subgroupId'=>$item->id)));

            if($sub!=null){
                foreach($sub as $i) $subitems[$i->id]=$i->subgroup;
                $subgroups=array_merge($subgroups,array($item->name=>$subitems));
            }
        }

        return $subgroups;

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
