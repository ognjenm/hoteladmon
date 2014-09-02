<?php

/**
 * This is the model class for table "zones".
 *
 * The followings are the available columns in table 'zones':
 * @property integer $id
 * @property string $zone
 * @property integer $used
 */
class Zones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'zones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('used', 'numerical', 'integerOnly'=>true),
			array('zone', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, zone, used', 'safe', 'on'=>'search'),
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
			'zone' => Yii::t('mx','Zone'),
			'used' => 'Used',
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
		$criteria->compare('zone',$this->zone,true);
		$criteria->compare('used',$this->used);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>array(
                    'used'=>CSort::SORT_DESC,
                )
            ),
		));
	}

    public function getForm(){

        return array(
            'id'=>'zones-form',
            'showErrorSummary' => true,
            'elements'=>array(
                'zone'=>array(
                    'type'=>'text',
                    'prepend'=>'<i class="icon-home"></i>',
                ),
            ),

            'buttons' => array(

                'budget' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Save'),
                    'url'=>Yii::app()->createUrl('/tasks/zone'),
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
                                $("#Tasks_zone").html(data.message);
                                $("#Providers_zone").html(data.message);
                                $("#modal-zones").modal("hide");
                                $("#Zones_zone").val("");
                            }
                        }',
                    ),
                ),

            )
        );
    }

    public function listAll(){
        return CHtml::listData($this->model()->findAll(array('order'=>'used desc')),'id','zone');
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
