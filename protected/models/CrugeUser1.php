<?php

/**
 * This is the model class for table "cruge_user".
 *
 * The followings are the available columns in table 'cruge_user':
 * @property integer $iduser
 * @property string $regdate
 * @property string $actdate
 * @property string $logondate
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $authkey
 * @property integer $state
 * @property integer $totalsessioncounter
 * @property integer $currentsessioncounter
 *
 * The followings are the available model relations:
 * @property CrugeAuthitem[] $crugeAuthitems
 * @property CrugeFieldvalue[] $crugeFieldvalues
 */
class CrugeUser1 extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CrugeUser1 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cruge_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('state, totalsessioncounter, currentsessioncounter', 'numerical', 'integerOnly'=>true),
			array('regdate, actdate, logondate', 'length', 'max'=>30),
			array('username, password', 'length', 'max'=>64),
			array('email', 'length', 'max'=>45),
			array('authkey', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('iduser, regdate, actdate, logondate, username, email, password, authkey, state, totalsessioncounter, currentsessioncounter', 'safe', 'on'=>'search'),
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
			'crugeAuthitems' => array(self::MANY_MANY, 'CrugeAuthitem', 'cruge_authassignment(userid, itemname)'),
			'crugeFieldvalues' => array(self::HAS_MANY, 'CrugeFieldvalue', 'iduser'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'iduser' => 'Iduser',
			'regdate' => 'Regdate',
			'actdate' => 'Actdate',
			'logondate' => 'Logondate',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'authkey' => 'Authkey',
			'state' => 'State',
			'totalsessioncounter' => 'Totalsessioncounter',
			'currentsessioncounter' => 'Currentsessioncounter',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('regdate',$this->regdate,true);
		$criteria->compare('actdate',$this->actdate,true);
		$criteria->compare('logondate',$this->logondate,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('authkey',$this->authkey,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('totalsessioncounter',$this->totalsessioncounter);
		$criteria->compare('currentsessioncounter',$this->currentsessioncounter);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function listFullname(){

        $comboList = array();

        $users=Employees::model()->findAll();


        foreach($users as $user){

            if($user->primaryKey != CrugeUtil::config()->guestUserId){

                $firstName = Yii::app()->user->um->getFieldValue($user,'nombres');
                $lastName = Yii::app()->user->um->getFieldValue($user,'apellidos');

            }

        }

        return $comboList;

    }

    public function getFullNameUser($userId){

        $nombres = Yii::app()->user->um->getFieldValue($userId,'nombres');
        $apellidos = Yii::app()->user->um->getFieldValue($userId,'apellidos');

        return $nombres.", ".$apellidos;

    }

    public function listUserName(){

        $comboList = array(0=>Yii::t('mx','Select'));

        foreach(Yii::app()->user->um->listUsers() as $user){

            if($user->primaryKey != CrugeUtil::config()->guestUserId && $user->state!=2)
               $comboList[$user->primaryKey] = $user->username;
        }

        return $comboList;

    }



}