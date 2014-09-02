<?php

/**
 * This is the model class for table "petty_cash".
 *
 * The followings are the available columns in table 'petty_cash':
 * @property integer $id
 * @property integer $user_id
 * @property string $amount
 * @property string $datex
 * @property integer $isconfirmed
 *
 * The followings are the available model relations:
 * @property PcSummary[] $pcSummaries
 */
class PettyCash extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'petty_cash';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, amount, datex', 'required'),
			array('user_id, isconfirmed', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, amount, datex, isconfirmed', 'safe', 'on'=>'search'),
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
            'pcSummaries' => array(self::HAS_MANY, 'PcSummary', 'petty_cash_id'),
            'employe' => array(self::BELONGS_TO, 'Employees', 'user_id'),
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
            'amount' => Yii::t('mx','Amount'),
            'datex' => Yii::t('mx','Date'),
            'isopen' => Yii::t('mx','Open'),
            'isconfirmed' => Yii::t('mx','Confirmed'),
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
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('datex',$this->datex,true);
		$criteria->compare('isconfirmed',$this->isconfirmed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave(){

        $datex=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->datex);
        $this->datex=date("Y-m-d",strtotime($datex));

        return parent::beforeSave();

    }

    public function afterFind() {

        $this->datex=date("d-M-Y",strtotime($this->datex));
        return  parent::afterFind();
    }


    public function getForm(){

        return array(
            'id'=>'pettycash-form',
            'showErrorSummary' => true,
            'elements'=>array(
                'amount'=>array(
                    'type'=>'text',
                    'prepend'=>'$',
                    //'enabled'=>false
                ),
            ),

            'buttons' => array(

                'ok' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Save'),
                    'url'=>Yii::app()->createUrl('/pettyCash/confirmed'),
                    'ajaxOptions' => array(
                        'dataType'=>'json',
                        'beforeSend' => 'function() { $(".modal-body").addClass("saving"); }',
                        'complete' => 'function() {  $(".modal-body").removeClass("saving"); }',
                        'success' =>'function(data){
                            if(data.ok==true){
                                $("#modal-pettyCash").modal("hide");
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
