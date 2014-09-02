<?php

class ConceptPayments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'concept_payments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('provider_id, concept', 'required'),
			array('provider_id', 'numerical', 'integerOnly'=>true),
			array('concept', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, provider_id, concept', 'safe', 'on'=>'search'),
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
            'provider' => array(self::BELONGS_TO, 'Providers', 'provider_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'provider_id' => Yii::t('mx','Provider'),
			'concept' => Yii::t('mx','Concept'),
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('concept',$this->concept,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listAll(){
        $list=array(
            0=>'No existen concepto de pagos'
        );

        $res=$this->model()->findAll(array('order'=>'concept'));

        if($res){
            $list=array(0=>Yii::t('mx','Select'));

            foreach($res as $item){
                $list[$item->concept]=$item->concept;
            }
        }

        return $list;
    }

    public function getForm(){

        return array(
            'id'=>'Concept-payment-form',
            'showErrorSummary' => true,
            'elements'=>array(
                'provider_id'=>array(
                    'type'=>'select2',
                    'data'=>Providers::model()->listAllOrganization(),
                ),
                'concept'=>array(
                    'type'=>'text',
                ),
            ),
            'buttons' => array(
                'concepts' => array(
                    'type' => 'button',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Create'),
                    'htmlOptions'=>array(
                        'onclick'=>"

                             var formulario=$('#Concept-payment-form').serialize();

                             $.ajax({
                                url: '".CController::createUrl('/conceptPayments/create')."',
                                data: formulario,
                                type: 'POST',
                                dataType: 'json',
                                beforeSend: function() { $('#body-conceptPayment').addClass('saving'); }
                            })

                            .done(function(data) {

                                  if(data.ok==true){
                                        $('#Operations_concept').html(data.concepts);
                                        $('#body-conceptPayment').removeClass('saving');
                                        $('#modal-conceptx').modal('hide');
                                    }
                             })

                            .fail(function() { bootbox.alert('Error');  })
                            .always(function() { $('#body-conceptPayment').removeClass('saving'); });

                        "
                    )
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
