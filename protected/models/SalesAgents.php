<?php


class SalesAgents extends CActiveRecord
{

	public function tableName()
	{
		return 'sales_agents';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('commission', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, commission', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'polls' => array(self::HAS_MANY, 'Poll', 'sales_agent_id'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'commission' => 'Commission',
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('commission',$this->commission);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listSalesAgents(){
        return CHtml::listData($this->model()->findAll(array('order'=>'id')),'id','name');
    }

    public function getForm()
    {
        return array(
            //'title' => Yii::t('mx','How we contact the customer?'),
            'showErrorSummary' => true,
            'elements' => array(
                'name'=>array(
                    'type'=>'text',
                    'class' => 'input-large',
                    'prepend'=>'<i class="icon-user"></i>'
                ),
                'commission'=>array(
                    'type'=>'text',
                    'class' => 'input-large',
                    'prepend'=>'%'
                ),
            ),
            'buttons' => array(
                'save' => array(
                    'type' => 'ajaxSubmit',
                    'label' => Yii::t('mx','Save'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-ok',
                    'url'=>Yii::app()->createUrl('/salesAgents/create'),
                    'ajaxOptions' => array(
                        'type'=>'POST',
                        //'dataType'=>'json',
                        'beforeSend' => 'function() { $("#saveSalesAgents").addClass("saving"); }',
                        'complete' => 'function() {   $("#saveSalesAgents").removeClass("saving"); }',
                        'success' =>'function(data){
                            if(data){
                                $("#salesAgent1").hide();
                                $("#Poll_sales_agent_id").html(data);
                            }
                        }',
                    ),
                ),
            )
        );
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
