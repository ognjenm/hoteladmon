<?php

/**
 * This is the model class for table "bdgt_reservation".
 *
 * The followings are the available columns in table 'bdgt_reservation':
 * @property integer $id
 * @property integer $bdgt_group_id
 * @property integer $bdgt_concept_id
 * @property integer $customer_reservation_id
 * @property string $fecha
 * @property string $hora
 * @property integer $pax
 * @property string $price
 */
class BdgtReservation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bdgt_reservation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bdgt_group_id, bdgt_concept_id, customer_reservation_id', 'required'),
			array('bdgt_group_id, bdgt_concept_id, customer_reservation_id, pax', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>10),
			array('fecha, hora', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bdgt_group_id, bdgt_concept_id, customer_reservation_id, fecha, hora, pax, price', 'safe', 'on'=>'search'),
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
			'bdgt_group_id' => 'Group',
			'bdgt_concept_id' => 'Concept',
			'customer_reservation_id' => 'Customer',
			'fecha' => 'Date',
			'hora' => 'Time',
			'pax' => 'Pax',
			'price' => 'Price',
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
		$criteria->compare('bdgt_group_id',$this->bdgt_group_id);
		$criteria->compare('bdgt_concept_id',$this->bdgt_concept_id);
		$criteria->compare('customer_reservation_id',$this->customer_reservation_id);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora,true);
		$criteria->compare('pax',$this->pax);
		$criteria->compare('price',$this->price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getForm(){

        return array(

            'elements'=>array(
                "bdgt_group_id"=>array(
                    'type'=>'dropdownlist',
                    'items'=>BdgtGroups::model()->listAll(),
                    'prompt'=>Yii::t('mx','Select'),
                    'onchange'=>'

                        var groupId=$(this).val();
                        var index=$(this).attr("id");
                        index=index.substring(29,31);

                        $.ajax({
                            url: "'.CController::createUrl('/bdgtConcepts/getConcepts').'",
                            data: { groupId: groupId },
                            type: "POST",
                            beforeSend: function() {  $("#maindiv").addClass("loading"); }
                        })

                        .done(function(data) { $("#BdgtReservation_bdgt_concept_id"+index).html(data); })
                        .fail(function() { bootbox.alert( "error" ); })
                        .always(function() { $("#maindiv").removeClass("loading"); });

                    ',
                ),
                "bdgt_concept_id"=>array(
                    'type'=>'dropdownlist',
                    'items'=>array(),
                    'prompt'=>Yii::t('mx','Select'),
                ),
                "fecha" => array(
                    'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
                    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                    'mode'=>'datetime',
                    'options'=>array(
                        'showAnim'=>'slide',
                        'changeYear' => true,
                        'changeMonth' => true,
                        'dateFormat'=>Yii::app()->format->dateFormat,
                        'timeText'=> Yii::t('mx','Schedule'),
                        'hourText'=> Yii::t('mx','Hour'),
                        'minuteText'=>Yii::t('mx','Minute'),
                        'timeOnlyTitle'=>Yii::t('mx','Choose Time'),
                        'minDate'=>0
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),
                ),
                "pax"=>array(
                    'type'=>'text',
                    'class' => 'input-medium',

                ),

            ),

            'buttons' => array(

                'budget' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-money',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Budget With Discount'),
                    'url'=>Yii::app()->createUrl('/bdgtReservation/budgetWithDiscount'),
                    'ajaxOptions' => array(
                        'beforeSend' => 'function() {
                            $("#maindiv").addClass("loading");
                         }',
                        'complete' => 'function() {
                             $("#maindiv").removeClass("loading");
                        }',
                        'success' =>'function(data){
                                $("#detailsGrid").html(data);
                                $("#actions").show();
                        }',
                    ),
                ),

                'undiscountedBudget' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-money',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Undiscounted Budget'),
                    'url'=>Yii::app()->createUrl('/reservation/undiscountedBudget'),
                    'ajaxOptions' => array(
                        'beforeSend' => 'function() {
                            $("#maindiv").addClass("loading");
                         }',
                        'complete' => 'function() {
                             $("#maindiv").removeClass("loading");
                        }',
                        'success' =>'function(data){
                                $("#detailsGrid").html(data);
                                $("#actions").show();
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
