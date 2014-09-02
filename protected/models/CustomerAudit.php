<?php

/**
 * This is the model class for table "customer_audit".
 *
 * The followings are the available columns in table 'customer_audit':
 * @property integer $id
 * @property integer $customer_id
 * @property string $field
 * @property string $old_value
 * @property string $new_value
 * @property string $action
 * @property string $stamp
 * @property integer $user_id
 */
class CustomerAudit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer_audit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, user_id', 'numerical', 'integerOnly'=>true),
			array('field', 'length', 'max'=>64),
			array('action', 'length', 'max'=>20),
			array('old_value, new_value, stamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, field, old_value, new_value, action, stamp, user_id', 'safe', 'on'=>'search'),
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
            'users' => array(self::BELONGS_TO, 'CrugeUser1', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_id' => Yii::t('mx','Customer'),
			'field' =>Yii::t('mx','Field'),
			'old_value' => Yii::t('mx','Old Value'),
			'new_value' => Yii::t('mx','New Value'),
			'action' => Yii::t('mx','Action'),
			'stamp' => Yii::t('mx','Stamp'),
			'user_id' =>Yii::t('mx','User') ,
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
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('old_value',$this->old_value,true);
		$criteria->compare('new_value',$this->new_value,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('stamp',$this->stamp,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function afterFind() {

        switch($this->field){
            case 'email' :              $this->field= Yii::t('mx','Email');  break;
            case 'alternative_email' :  $this->field= Yii::t('mx','Alternative Email'); break;
            case 'first_name' :         $this->field=Yii::t('mx','First Names');  break;
            case 'last_name' :          $this->field=Yii::t('mx','Last Names'); break;
            case 'country' :            $this->field=Yii::t('mx','Country'); break;
            case 'state' :              $this->field=Yii::t('mx','State'); break;
            case 'city' :               $this->field=Yii::t('mx','City'); break;
            case 'how_find_us' :        $this->field=Yii::t('mx','How did you hear about us?'); break;
            case 'home_phone' :         $this->field=Yii::t('mx','Home Phone'); break;
            case 'work_phone' :         $this->field=Yii::t('mx','Work Phone'); break;
            case 'cell_phone' :         $this->field=Yii::t('mx','Cell Phone'); break;
        }
        parent::afterFind();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomerAudit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
