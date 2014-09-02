<?php

/**
 * This is the model class for table "policies".
 *
 * The followings are the available columns in table 'policies':
 * @property integer $id
 * @property string $title
 * @property string $content
 */
class Policies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'policies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'length', 'max'=>255),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'content' => 'Content',
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
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Policies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function categories(){
        return array(
            'cabanas'=>Yii::t('mx',''),
            'tent'=>Yii::t('mx',''),
            'camped'=>Yii::t('mx',''),
            'daypass'=>Yii::t('mx',''),
            'events'=>Yii::t('mx',''),
            'packages'=>Yii::t('mx',''),
            'conditions'=>Yii::t('mx',''),
            'ubication'=>Yii::t('mx',''),
            'billing'=>Yii::t('mx',''),
            'activities'=>Yii::t('mx',''),
            'groups'=>Yii::t('mx',''),
            'events'=>Yii::t('mx','')


        );
    }

    public function listAllPolicies(){

        $res=array();

        $options=$this->model()->findAll(array('order'=>'Title'));

        foreach($options as $item){
            $res[]=$item->title;
        }

        return $res;
    }

    public function listAll(){
        return CHtml::listData($this::model()->findAll(array('order'=>'Title')), 'id', 'title');
    }

    public function behaviors()
    {
        return array(
            'LoggableBehavior'=>
                'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }


}
