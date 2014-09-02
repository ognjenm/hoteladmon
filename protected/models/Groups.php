<?php

/**
 * This is the model class for table "groups".
 *
 * The followings are the available columns in table 'groups':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property GroupAssignment[] $groupAssignments
 */
class Groups extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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
			'groupAssignments' => array(self::HAS_MANY, 'GroupAssignment', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Group',
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
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listAll2(){
        $groups=array();
        $list=array();

        $groups=Groups::model()->with(array(
            'groupAssignments'=>array(
                'together'=>true,
                'joinType'=>'INNER JOIN',
            ),

        ))->findAll(array('order'=>'name'));

        foreach($groups as $item){
            $subitems=array();
            foreach($item->groupAssignments as $asigned){
                $employee=Employees::model()->findByPk($asigned->employee_id);
                $subitems[$employee->id]=$employee->names;
                $list=array_merge($list,array($item->name=>$subitems));
            }
        }

        return $list;

    }

    public function listAll(){

        return CHtml::listData($this->model()->findAll(array('order'=>'name')),'id','name');
    }

    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
