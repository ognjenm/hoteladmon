<?php

/**
 * This is the model class for table "services".
 *
 * The followings are the available columns in table 'services':
 * @property integer $id
 * @property string $service
 */
class Services extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'services';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, service', 'safe', 'on'=>'search'),
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
			'service' => Yii::t('mx','Service'),
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
		$criteria->compare('service',$this->service,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listAll(){
        return CHtml::listData($this->model()->findAll(array('order'=>'service')),'id','service');
    }

    public function getForm(){

        return array(
            'id'=>'properties-form',
            'showErrorSummary' => true,
            'elements'=>array(
                'service'=>array(
                    'type'=>'text',
                    //'prepend'=>'<i class="icon-home"></i>',
                ),
            ),

            'buttons' => array(

                'budget' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Save'),
                    'url'=>Yii::app()->createUrl('/contractInformation/services'),
                    'ajaxOptions' => array(
                        'dataType'=>'json',
                        'beforeSend' => 'function() {
                            $(".modal-body").addClass("saving");
                         }',
                        'complete' => 'function() {
                             $(".modal-body").removeClass("saving");
                        }',
                        'success' =>'function(data){
                            if(data.ok==true){
                                $("#ContractInformation_service_id").html(data.message);
                                $("#modal-services").modal("hide");
                                $("#Services_service").val("");
                            }
                        }',
                    ),
                ),

            )
        );
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
