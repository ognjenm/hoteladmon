<?php

/**
 * This is the model class for table "pc_summary".
 *
 * The followings are the available columns in table 'pc_summary':
 * @property integer $id
 * @property integer $petty_cash_id
 * @property integer $provider_id
 * @property integer $article_id
 * @property integer $n_invoice
 * @property string $price
 * @property string $datex
 * @property integer $isactive
 * @property integer $isinvoice
 *
 * The followings are the available model relations:
 * @property PettyCash $pettyCash
 */
class PcSummary extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pc_summary';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('petty_cash_id, provider_id, article_id, price, datex', 'required'),
			array('petty_cash_id, provider_id, article_id, n_invoice, isactive, isinvoice', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, petty_cash_id, provider_id, article_id, n_invoice, price, datex, isactive, isinvoice', 'safe', 'on'=>'search'),
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
			'pettyCash' => array(self::BELONGS_TO, 'PettyCash', 'petty_cash_id'),
            'provider' => array(self::BELONGS_TO, 'Providers', 'provider_id'),
            'article' => array(self::BELONGS_TO, 'Articles', 'article_id'),

        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'petty_cash_id' => Yii::t('mx','N° Summary:'),
			'provider_id' => Yii::t('mx','Provider'),
			'article_id' => Yii::t('mx','Article'),
			'n_invoice' => Yii::t('mx','N° Invoice'),
			'price' => Yii::t('mx','Amount'),
			'datex' => Yii::t('mx','Date'),
			'isactive' => 'Isactive',
			'isinvoice' => 'Isinvoice',
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
        $pettyCashId=-1;

        $criteria2=array(
            'condition'=>'user_id=:userId',
            'params'=>array('userId'=>Yii::app()->user->id)
        );

        $pcSummary=PettyCash::model()->find($criteria2);
        if($pcSummary) $pettyCashId=(int)$pcSummary->id;


		$criteria->compare('id',$this->id);
		$criteria->compare('petty_cash_id',$pettyCashId);
		$criteria->compare('provider_id',$this->provider_id);
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('n_invoice',$this->n_invoice);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('datex',$this->datex,true);
		$criteria->compare('isactive',$this->isactive);
		$criteria->compare('isinvoice',$this->isinvoice);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function getIsInvoiced() {

        $statuscolor='white';

        switch ($this->isinvoice) {

            case 0:
                $statuscolor='warning';
                break;
        }

        return $statuscolor;

    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
