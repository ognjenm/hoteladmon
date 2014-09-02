<?php

/**
 * This is the model class for table "task_comments".
 *
 * The followings are the available columns in table 'task_comments':
 * @property integer $id
 * @property integer $user_id
 * @property integer $task_id
 * @property string $comment
 * @property string $timestampt
 */
class TaskComments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'task_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, task_id', 'required'),
			array('user_id, task_id', 'numerical', 'integerOnly'=>true),
			array('comment, timestampt', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, task_id, comment, timestampt', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => Yii::t('mx','User'),
			'task_id' => Yii::t('mx','Task'),
			'comment' => Yii::t('mx','Comment'),
			'timestampt' => Yii::t('mx','Date'),
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('timestampt',$this->timestampt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterFind() {

        $this->timestampt=date("d-M-Y H:i",strtotime($this->timestampt));

        return  parent::afterFind();
    }

    public function getForm($taskId=null){

        return array(
            'id'=>'comment-form',
            'showErrorSummary' => true,
            'elements'=>array(
                'comment'=>array(
                    'type'=>'textarea',
                    'rows'=>5,
                    'class'=>'span12'
                ),
            ),

            'buttons' => array(

                'budget' => array(
                    'type' => 'submit',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Save'),
                    'url'=>Yii::app()->createUrl('/tasks/comment'),
                    /*'ajaxOptions' => array(
                        'dataType'=>'json',
                        'data'=>array('taskId'=>$taskId),
                        'beforeSend' => 'function() {
                            $(".modal-body").addClass("saving");
                         }',
                        'complete' => 'function() {
                             $(".modal-body").removeClass("saving");
                        }',
                        'success' =>'function(data){
                            if(data.ok==true){
                                $("#modal-comment").modal("hide");
                                $("#TaskComments_comment").val("");
                            }
                        }',
                    ),*/
                ),

            )
        );
    }
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
