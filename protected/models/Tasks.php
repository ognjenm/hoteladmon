<?php

class Tasks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tasks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('status, duration, priority, department, isclose, days_after_date_due, zone, employee_id, isgroup, group_assigned_id, accepted_by, parent_id, created_by', 'numerical', 'integerOnly'=>true),
			array('name, accepted_users', 'length', 'max'=>100),
			array('description', 'length', 'max'=>500),
			array('duration_unit', 'length', 'max'=>20),
			array('frecuency', 'length', 'max'=>50),
			array('providers', 'length', 'max'=>300),
			array('date_start, date_due, date_finish, date_entered', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, date_start, date_due, date_finish, date_entered, status, duration, duration_unit, priority, department, isclose, days_after_date_due, zone, employee_id, isgroup, group_assigned_id, accepted_by, parent_id, frecuency, created_by, providers, accepted_users', 'safe', 'on'=>'search'),
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
            'department1' => array(self::BELONGS_TO, 'Departments', 'department'),
            'zone1'=>array(self::BELONGS_TO, 'Zones', 'zone'),
            'user'=>array(self::BELONGS_TO, 'CrugeUser1', 'accepted_by'),
            'created'=>array(self::BELONGS_TO, 'CrugeUser1', 'created_by'),
            'group'=>array(self::BELONGS_TO, 'Groups', 'group_assigned_id'),
            'employee'=>array(self::BELONGS_TO, 'Employees', 'employee_id'),
            'tracing' => array(self::HAS_MANY, 'TracingTask', 'task_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'name' => Yii::t('mx','Task'),
            'description' => Yii::t('mx','C.A'),
            'date_start' => Yii::t('mx','Date Start'),
            'date_due' => Yii::t('mx','Date Due'),
            'date_finish' => Yii::t('mx','Date Finish'),
            'date_entered' => Yii::t('mx','Date Entered'),
            'status' => Yii::t('mx','Status'),
            'duration' => Yii::t('mx','Duration'),
            'duration_unit' => Yii::t('mx','Duration Unit'),
            'priority' => Yii::t('mx','Prio'),
            'department' => Yii::t('mx','Department'),
            'isclose' => Yii::t('mx','Isclose'),
            'days_after_date_due' => Yii::t('mx','Days After Date Due'),
            'zone' => Yii::t('mx','Zone'),
            'employee_id' => Yii::t('mx','Employee'),
            'isgroup' => Yii::t('mx','Assigned to a group?'),
            'group_assigned_id' => Yii::t('mx','Group'),
            'assigned_to' => Yii::t('mx','Assigned To'),
            'accepted_by' => Yii::t('mx','Accepted By'),
            'parent_id' =>  Yii::t('mx','Parent'),
            'frecuency' =>  Yii::t('mx','Frecuency'),
            'created_by' =>  Yii::t('mx','Created By'),
            'providers' =>  Yii::t('mx','Providers'),
            'accepted_users' =>  Yii::t('mx','Accepted Users'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_start',$this->date_start,true);
		$criteria->compare('date_due',$this->date_due,true);
		$criteria->compare('date_finish',$this->date_finish,true);
		$criteria->compare('date_entered',$this->date_entered,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('duration_unit',$this->duration_unit,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('department',$this->department);
		$criteria->compare('isclose',$this->isclose);
		$criteria->compare('days_after_date_due',$this->days_after_date_due);
		$criteria->compare('zone',$this->zone);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('isgroup',$this->isgroup);
		$criteria->compare('group_assigned_id',$this->group_assigned_id);
		$criteria->compare('accepted_by',$this->accepted_by);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('frecuency',$this->frecuency,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('providers',$this->providers,true);
		$criteria->compare('accepted_users',$this->accepted_users,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>array(
                    'priority'=>CSort::SORT_ASC,
                )
            ),
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
	}


    public function mytasks()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        //$criteria->compare('status',$this->status);
        $criteria->compare('priority',$this->priority);
        $criteria->compare('department',$this->department);
        $criteria->compare('zone',$this->zone,true);
        $criteria->compare('date_due',$this->date_due,true);

        $employee=Employees::model()->find(array(
            'condition'=>'user_id=:userId',
            'params'=>array('userId'=>Yii::app()->user->id)
        ));

        $users=GroupAssignment::model()->find(array(
            'condition'=>'employee_id=:employeeId',
            'params'=>array('employeeId'=>$employee->id)
        ));

        $criteria->condition = '(status !=1 and isclose=0 and isgroup=1 and group_assigned_id=:groupAssigned) or (status !=1 and isclose=0 and isgroup=0 and employee_id=:employeeId)';
        $criteria->params = array(':groupAssigned'=>$users->group_id,':employeeId' =>$employee->id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>array(
                    'priority'=>CSort::SORT_ASC,
                )
            ),
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
    }


    public function history()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('priority',$this->priority);
        $criteria->compare('department',$this->department);
        $criteria->compare('zone',$this->zone,true);
        $criteria->compare('date_due',$this->date_due,true);

        //if(Yii::app()->user->isSuperAdmin) $criteria->compare('accepted_by',$this->accepted_by);
        //else $criteria->compare('accepted_by',Yii::app()->user->id);
        //$criteria->compare('isclose',1);

        $employee=Employees::model()->find(array(
            'condition'=>'user_id=:userId',
            'params'=>array('userId'=>Yii::app()->user->id)
        ));

        $users=GroupAssignment::model()->find(array(
            'condition'=>'employee_id=:employeeId',
            'params'=>array('employeeId'=>$employee->id)
        ));

        $criteria->condition = '(isclose=1 and isgroup=1 and group_assigned_id=:groupAssigned) or (isclose=1 and isgroup=0 and employee_id=:employeeId)';
        $criteria->params = array(':groupAssigned'=>$users->group_id,':employeeId' =>$employee->id);


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>array(
                    'priority'=>CSort::SORT_ASC,
                )
            ),
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
    }

    public function listFrecuency(){
        return array(
            'Once'=>Yii::t('mx','Once'),
            'Daily'=>Yii::t('mx','Daily'),
            'Weekly'=>Yii::t('mx','Weekly'),
            'Monthly'=>Yii::t('mx','Monthly'),
        );
    }


    public function listPriority(){

        return array(
            '1'=>1,
            '2'=>2,
            '3'=>3,
            '4'=>4,
            '5'=>5,
        );
    }

    public function priorityColor($color){

        $class=array(
            '1'=>'badge badge-important',
            '2'=>'badge badge-warning',
            '3'=>'badge badge-info',
        );

        return $class[$color];
    }



    public function statusColor($color){

        $class=array(
            '1'=>'badge badge-success',
            '2'=>'badge badge-inverse',
            //'3'=>'badge badge-warning',
            '4'=>'badge badge-important',
            '5'=>'badge badge-info',
        );

        return $class[$color];
    }

    public function listStatus(){
        return array(
            '1'=>Yii::t('mx','Completed'),
            '2'=>Yii::t('mx','Deferred'),
            //'3'=>Yii::t('mx','Pending'),
            '4'=>Yii::t('mx','Not Started'),
            '5'=>Yii::t('mx','In Progress'),
        );
    }

    public function displayStatus($status){
        $arrayStatus= array(
            '1'=>Yii::t('mx','Completed'),
            '2'=>Yii::t('mx','Deferred'),
            //'3'=>Yii::t('mx','Pending'),
            '4'=>Yii::t('mx','Not Started'),
            '5'=>Yii::t('mx','In Progress'),
        );

        return $arrayStatus[$status];
    }


    public function afterFind() {

        $datedue=date("Y-M-d H:i",strtotime($this->date_due));
        $this->date_due=Yii::app()->quoteUtil->toSpanishDateTime1($datedue);

        $dateentered=date("Y-M-d H:i",strtotime($this->date_entered));
        $this->date_entered=Yii::app()->quoteUtil->toSpanishDateTime1($dateentered);

        return  parent::afterFind();
    }

    public function beforeSave(){

        $datedue=Yii::app()->quoteUtil->ToEnglishDateTime1($this->date_due);
        $this->date_due=date("Y-m-d H:i",strtotime($datedue));

        $dateentered=Yii::app()->quoteUtil->ToEnglishDateTime1($this->date_entered);
        $this->date_entered=date("Y-m-d H:i",strtotime($dateentered));

        return parent::beforeSave();

    }


    public static function popoverComments($data){

        $popover=Yii::t('mx','Not set');

        if($data!=null){

            $popover='<p class="popover-examples">';
            $popover.='<a href="#"';
            $popover.=' class="" data-toggle="popover"';
            $popover.=' data-title="';
            $popover.='<h4>'.Yii::t('mx','Comments').'</h4>';
            $popover.='"';
            $popover.=' data-content="';
            $popover.='<p>'.$data.'</p>';
            $popover.='">';
            $popover.=substr($data,0,3);
            $popover.='</a>';
            $popover.='</p>';

        }

        return $popover;

    }


    public static function popover($data){

        $popover=Yii::t('mx','Not set');

        if($data!=null){
            $datos=array();
            $datos=explode(',',$data);
            $popover='<p class="popover-examples">';


            foreach($datos as $item){

                $provider= Providers::model()->findByPk($item);

                $url= Yii::app()->createUrl('/providers/view',array('id'=>$provider->id));

                $popover.='<a href="';
                $popover.=$url;
                $popover.='" class="" data-toggle="popover"';
                $popover.=' data-title="';
                $popover.='<h4>'.$provider->first_name.' '.$provider->middle_name.' '.$provider->last_name.'</h4>';
                $popover.='"';
                $popover.=' data-content="';
                $popover.='<p><h5>'.$provider->company.'</h5></p>';
                $popover.='<hr>';
                if($provider->telephone_work1) $popover.='<p><strong>'.Yii::t('mx','Telephone Work1').':</strong> '.$provider->telephone_work1.'</p>';
                if($provider->telephone_work2) $popover.='<p><strong>'.Yii::t('mx','Telephone Work2').':</strong> '.$provider->telephone_work2.'</p>';
                if($provider->telephone_home1) $popover.='<p><strong>'.Yii::t('mx','Telephone Home1').':</strong> '.$provider->telephone_home1.'</p>';
                if($provider->telephone_home2) $popover.='<p><strong>'.Yii::t('mx','Telephone Home2').':</strong> '.$provider->telephone_home2.'</p>';
                if($provider->fax_work) $popover.='<p><strong>'.Yii::t('mx','Fax').': '.$provider->fax_work.'</p>';
                if($provider->cell_phone) $popover.='<p><strong>'.Yii::t('mx','Cell Phone').':</strong> '.$provider->cell_phone.'</p>';
                if($provider->email_work) $popover.='<p><strong>'.Yii::t('mx','Email Work').':</strong> '.$provider->email_work.'</p>';
                if($provider->email_home) $popover.='<p><strong>'.Yii::t('mx','Email Home').':</strong> '.$provider->email_home.'</p>';
                if($provider->email) $popover.='<p><strong>'.Yii::t('mx','Email').':</strong> '.$provider->email.'</p>';
                $popover.='">';
                $popover.='<i class="icon-list-alt icon-large"></i>';
                $popover.='</a>';
                $popover.=', ';

            }

            $popover.='</p>';
        }


        return $popover;

    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
