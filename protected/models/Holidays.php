<?php

/**
 * This is the model class for table "holidays".
 *
 * The followings are the available columns in table 'holidays':
 * @property integer $id
 * @property string $day
 * @property string $commemoration
 */
class Holidays extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'holidays';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('day', 'required'),
			array('commemoration', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, day, commemoration', 'safe', 'on'=>'search'),
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
			'day' => Yii::t('mx','Day'),
			'commemoration' => Yii::t('mx','Commemoration'),
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
		$criteria->compare('day',$this->day,true);
		$criteria->compare('commemoration',$this->commemoration,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterFind() {

        $this->day=date("d-M-Y",strtotime($this->day));

        return  parent::afterFind();
    }

    public function beforeSave(){

        $date=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->day);
        $this->day=date("Y-m-d",strtotime($date));

        return parent::beforeSave();

    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
