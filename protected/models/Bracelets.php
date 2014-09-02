<?php

/**
 * This is the model class for table "bracelets".
 *
 * The followings are the available columns in table 'bracelets':
 * @property integer $id
 * @property integer $use_id
 * @property string $color
 *
 * The followings are the available model relations:
 * @property Assignment[] $assignments
 * @property Uses $use
 */
class Bracelets extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bracelets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('use_id, color', 'required'),
			array('use_id', 'numerical', 'integerOnly'=>true),
			array('color', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, use_id, color', 'safe', 'on'=>'search'),
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
			'assignments' => array(self::HAS_MANY, 'Assignment', 'bracelet_id'),
			'use' => array(self::BELONGS_TO, 'Uses', 'use_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'use_id' => Yii::t('mx','Use'),
			'color' => Yii::t('mx','Color'),
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
		$criteria->compare('use_id',$this->use_id);
		$criteria->compare('color',$this->color,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listAll(){

        $lista=array(''=>Yii::t('mx','Select'));
        $result=$this->model()->findAll(array('order'=>'color'));

        foreach($result as $item){
            $lista[$item->id]=$item->color.' - '.$item->use->used;
        }

        return $lista;

    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'LoggableBehavior'=>
                'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }
}
