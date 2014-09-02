<?php

class DocumentTypes extends CActiveRecord
{

	public function tableName()
	{
		return 'document_types';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('billable', 'numerical', 'integerOnly'=>true),
			array('document_type', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, document_type, billable', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{

		return array(
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'document_type' => Yii::t('mx','Document Type'),
			'billable' => Yii::t('mx','Billable'),
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('document_type',$this->document_type,true);
		$criteria->compare('billable',$this->billable);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getForm(){

        return array(
            'id'=>'zones-form',
            'showErrorSummary' => true,
            'elements'=>array(
                'document_type'=>array(
                    'type'=>'text',
                    'prepend'=>'<i class="icon-file"></i>',
                ),
            ),

            'buttons' => array(

                'budget' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Save'),
                    'url'=>Yii::app()->createUrl('/documentTypes/create'),
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
                                $("#DirectInvoice_document_type_id").html(data.message);
                                $("#modal-documentType").modal("hide");
                                $("#DocumentTypes_document_type").val("");
                            }
                        }',
                    ),
                ),

            )
        );
    }

    public function listAll(){
        return CHtml::listData($this->model()->findAll(array('order'=>'document_type')),'id','document_type');
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
