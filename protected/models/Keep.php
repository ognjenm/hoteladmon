<?php

/**
 * This is the model class for table "keep_main".
 *
 * The followings are the available columns in table 'keep_main':
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $remember
 * @property integer $active
 * @property string $datetime
 *
 * The followings are the available model relations:
 * @property KeepItems[] $keepItems
 */
class Keep extends CActiveRecord
{
	public $item;

	public function tableName()
	{
		return 'keep_main';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('active', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>200),
			array('image', 'length', 'max'=>20),
			array('remember, datetime', 'safe'),
            array('item', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, image, remember, active, datetime', 'safe', 'on'=>'search'),
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
			'keepItems' => array(self::HAS_MANY, 'KeepItems', 'keep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => Yii::t('mx','Title'),
			'image' => Yii::t('mx','Image'),
			'remember' => Yii::t('mx','Remember'),
			'active' => Yii::t('mx','Active'),
			'datetime' => Yii::t('mx','Date'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('remember',$this->remember,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('datetime',$this->datetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Keep the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
