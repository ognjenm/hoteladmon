<?php

/**
 * This is the model class for table "tracing_task".
 *
 * The followings are the available columns in table 'tracing_task':
 * @property integer $id
 * @property integer $task_id
 * @property integer $reason_id
 * @property integer $user_id
 * @property string $tracing_date
 * @property string $tracing_delay
 * @property string $tracing_expiration
 * @property string $task_expiration
 * @property integer $unit
 * @property integer $duration_unit
 * @property string $comment
 * @property integer $notified
 * @property string $tracing_expiration_date
 */
class TracingTask extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tracing_task';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, tracing_date, comment', 'required'),
			array('task_id, reason_id, user_id, unit, duration_unit, notified', 'numerical', 'integerOnly'=>true),
			array('tracing_delay, tracing_expiration, task_expiration', 'length', 'max'=>50),
			array('tracing_expiration_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, task_id, reason_id, user_id, tracing_date, tracing_delay, tracing_expiration, task_expiration, unit, duration_unit, comment, notified, tracing_expiration_date', 'safe', 'on'=>'search'),
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
            'user'=>array(self::BELONGS_TO, 'CrugeUser1', 'user_id'),
            'task'=>array(self::BELONGS_TO, 'Tasks', 'task_id'),
            'reason'=>array(self::BELONGS_TO, 'Reasons', 'reason_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'task_id' => Yii::t('mx','Task'),
            'reason_id' => Yii::t('mx','Reason'),
            'user_id' => Yii::t('mx','User'),
            'tracing_date' => Yii::t('mx','Date'),
            'tracing_delay' => Yii::t('mx','Tracing Delay'),
            'tracing_expiration' => Yii::t('mx','Tracing Expiration'),
            'task_expiration' => Yii::t('mx','Task Expiration'),
            'unit' => Yii::t('mx','Unit'),
            'duration_unit' => Yii::t('mx','Duration Unit'),
            'comment' => Yii::t('mx','Comments'),
            'notified' => Yii::t('mx','Notified'),
			'tracing_expiration_date' => Yii::t('mx','Tracing Expiration Date'),
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
		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('reason_id',$this->reason_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('tracing_date',$this->tracing_date,true);
		$criteria->compare('tracing_delay',$this->tracing_delay,true);
		$criteria->compare('tracing_expiration',$this->tracing_expiration,true);
		$criteria->compare('task_expiration',$this->task_expiration,true);
		$criteria->compare('unit',$this->unit);
		$criteria->compare('duration_unit',$this->duration_unit);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('notified',$this->notified);
		$criteria->compare('tracing_expiration_date',$this->tracing_expiration_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listDurationUnit(){

        return array(
            1=>Yii::t('mx','Mins'),
            2=>Yii::t('mx','Hours'),
            3=>Yii::t('mx','Days'),
            4=>Yii::t('mx','Weeks'),
        );
    }

    public function displayDurationUnit($unit){

        $durations= array(
            1=>Yii::t('mx','Mins'),
            2=>Yii::t('mx','Hours'),
            3=>Yii::t('mx','Days'),
            4=>Yii::t('mx','Weeks'),
        );

        $indice=(int)$unit;

        return $durations[$indice];
    }

    public function afterFind() {

        $tracingdate=date("Y-M-d H:i",strtotime($this->tracing_date));
        $this->tracing_date=Yii::app()->quoteUtil->toSpanishDateTime1($tracingdate);

        return  parent::afterFind();
    }

    public function beforeSave(){

        $tracingdate=Yii::app()->quoteUtil->ToEnglishDateTime1($this->tracing_date);
        $this->tracing_date=date("Y-m-d H:i",strtotime($tracingdate));

        return parent::beforeSave();

    }



    /*public function afterFind() {
        $this->tracing_date=date("d-M-Y H:i",strtotime($this->tracing_date));
        return  parent::afterFind();
    }*/



	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
