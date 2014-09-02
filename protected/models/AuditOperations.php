<?php

/**
 * This is the model class for table "audit_operations".
 *
 * The followings are the available columns in table 'audit_operations':
 * @property integer $id
 * @property integer $operation_id
 * @property string $field
 * @property string $old_value
 * @property string $new_value
 * @property string $action
 * @property string $stamp
 * @property integer $user_id
 */
class AuditOperations extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'audit_operations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operation_id, user_id', 'numerical', 'integerOnly'=>true),
			array('field', 'length', 'max'=>64),
			array('action', 'length', 'max'=>20),
			array('old_value, new_value, stamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, operation_id, field, old_value, new_value, action, stamp, user_id', 'safe', 'on'=>'search'),
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
			'operation_id' => Yii::t('mx','Operation'),
			'field' => Yii::t('mx','Field'),
			'old_value' => Yii::t('mx','Old Value'),
			'new_value' => Yii::t('mx','New Value'),
			'action' => Yii::t('mx','Action'),
			'stamp' => Yii::t('mx','Stamp'),
			'user_id' => Yii::t('mx','User'),
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('operation_id',$this->operation_id);
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
            case 'payment_type' :
                $this->field= Yii::t('mx','payment_type');
                $iNewValue=(int)$this->new_value;
                $iOldValue=(int)$this->old_value;
                $newValue=PaymentsTypes::model()->findByPk($iNewValue);
                $oldValue=PaymentsTypes::model()->findByPk($iOldValue);
                if($newValue) $this->new_value=$newValue->payment;
                if($oldValue) $this->old_value=$oldValue->payment;
            break;

            case 'bank_id' :
                $this->field= Yii::t('mx','bank_id');
                $iNewValue=(int)$this->new_value;
                $iOldValue=(int)$this->old_value;
                $newValue=Banks::model()->showByPk($iNewValue);
                $oldValue= Banks::model()->showByPk($iOldValue);
                if($newValue) $this->new_value=$newValue;
                if($oldValue) $this->old_value=$oldValue;

            break;

            case 'cheq' :         $this->field=Yii::t('mx','cheq');  break;
            case 'datex' :
                $this->field=Yii::t('mx','datex');
                //$date= date("d-M-Y",strtotime($this->datex));
                //$this->datex=$date;
            break;

            case 'released' :            $this->field=Yii::t('mx','released'); break;
            case 'concept' :              $this->field=Yii::t('mx','concept'); break;
            case 'person' :               $this->field=Yii::t('mx','person'); break;
            case 'bank_concept' :        $this->field=Yii::t('mx','bank_concept'); break;
            case 'retirement' :         $this->field=Yii::t('mx','retirement'); break;
            case 'deposit' :         $this->field=Yii::t('mx','deposit'); break;
            case 'balance' :         $this->field=Yii::t('mx','balance'); break;
        }
        parent::afterFind();
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
