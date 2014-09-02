<?php

class TasksController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            array('CrugeAccessControlFilter'), // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','index','view','delete','close','accept',
                                'editStatus','reallocate','myTasks','history','department','zone',
                                'tracing','reason','tracingExpiration','getDays','notified'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionNotified($id){

        $res=array('ok'=>false);

        if(Yii::app()->request->isPostRequest){

            $tasks=TracingTask::model()->findByPk($id);
            $tasks->notified=1;

            if($tasks->save()){
                $res=array('ok'=>true);
            }
        }

        echo CJSON::encode($res);
        Yii::app()->end();

    }


    public function actionGetDays(){

            $res=array('ok'=>false);
            $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);

            if(Yii::app()->request->isPostRequest){

                $valor=$_POST['valor'];

                if($valor==1){
                    for($i=1;$i<=59;$i++){
                        $options.=CHtml::tag('option', array('value'=>$i),$i,true);
                    }
                }

                if($valor==2){
                    for($i=1;$i<=23;$i++){
                        $options.=CHtml::tag('option', array('value'=>$i),$i,true);
                    }
                }

                if($valor==3){
                    for($i=1;$i<=31;$i++){
                        $options.=CHtml::tag('option', array('value'=>$i),$i,true);
                    }
                }

                if($valor==4){
                    for($i=1;$i<=52;$i++){
                        $options.=CHtml::tag('option', array('value'=>$i),$i,true);
                    }
                }

                $res=array('ok'=>true,'list'=>$options);

            }

            echo CJSON::encode($res);
            Yii::app()->end();


    }

    public function actionTracingExpiration(){
        $res=array('ok'=>false);
        $userId=(int)$_POST['userId'];
        $pendingTask=0;

        if(Yii::app()->request->isPostRequest){

            $tracing = Yii::app()->db->createCommand()
                ->select("tracing_task.*")
                ->from('tasks')
                ->join('tracing_task','tasks.id =tracing_task.task_id')
                ->where('tasks.accepted_by=:accepted and tasks.status!=1 and tracing_task.unit!=0 and tracing_task.notified=0',
                    array(':accepted'=>$userId))
                ->queryAll();

            //agregarle el campo a tracing task el de fecha algo como date_task_expiration
            foreach($tracing as $item){
                $pendingTask++;
                $currentTime=strtotime(date('Y-m-d H:i'));
                $taskExpiration=strtotime($item->tracing_expiration_date);
                if($taskExpiration <=$currentTime){
                    $pendingTask++;
                }
            }

            $res=array('ok'=>true,'tasks'=>$pendingTask);

        }

        echo CJSON::encode($res);
        Yii::app()->end();

    }

    public function actionTracing($id){
        Yii::import('bootstrap.widgets.TbForm');
        $model=new TracingTask;
        $reason=new Reasons;
        $taskId=(int)$id;

        $fReason = TbForm::createForm($reason->getForm(),$reason,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

        if(isset($_POST['TracingTask']))
        {
            $model->attributes=$_POST['TracingTask'];
            $model->task_id=$taskId;
            $model->user_id=Yii::app()->user->id;
            $model->tracing_date=Yii::app()->quoteUtil->toSpanishDateTime1(date('Y-M-d H:i'));

            if($model->unit!= null && $model->duration_unit!=null)
                $model->tracing_expiration=$model->unit." - ".TracingTask::model()->displayDurationUnit($model->duration_unit);

            //calcula cuando falta para llegar a la fecha de vencimiento de la tarea en ,dias,horas,minutos

            $task=Tasks::model()->findByPk($taskId);

            $FdateDue=Yii::app()->quoteUtil->toEnglishDateTime1($task->date_due);
            $dateDue=new DateTime($FdateDue);
            $currentDate=new DateTime(date('Y-m-d H:i'));

            if(strtotime($task->date_due) > strtotime(date('Y-m-d H:i'))){
                $dif=date_diff($dateDue,$currentDate);

                $dias=$dif->d;
                $horas=$dif->h;
                $minutos=$dif->i;

                $dias.=" ".Yii::t('mx','Days');
                $horas.=" ".Yii::t('mx','Hours');
                $minutos.=" ".Yii::t('mx','Minuts');

                $model->task_expiration=$dias.', '.$horas.', '.$minutos;

                if($model->unit!= null && $model->duration_unit!=null){

                    switch ($model->duration_unit) {
                        case 1 : $interval = 'PT'.$model->unit.'M';
                            break;
                        case 2 : $interval = 'PT'.$model->unit.'H';
                            break;
                        case 3 : $interval = 'P'.$model->unit.'D';
                            break;
                        case 4 :
                            $semanas=$model->unit*7;
                            $interval = 'P'.$semanas.'D';
                            break;
                    }

                    $currentDate->add(new DateInterval($interval));
                    $model->tracing_expiration_date=$currentDate->format('Y-m-d H:i');
                }


            }

            if($model->save()){

                if($model->reason->reason=="Terminado"){
                    $task->isclose=1;
                    $task->status=1;
                    $task->save();

                    Yii::app()->user->setFlash('success','Success');
                    $this->redirect(array('myTasks'));

                }else{
                    Yii::app()->user->setFlash('success','Success');
                    $this->redirect(array('view','id'=>$taskId));
                }

            }

        }

        $this->render('tracing',array(
            'model'=>$model,
            'reason'=>$fReason
        ));
    }


    public function actionReason(){

        $res=array('ok'=>false);
        $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);

        if(Yii::app()->request->isPostRequest){

            if(!empty($_POST['Reasons'])){

                $reason=new Reasons;
                $reason->reason=$_POST['Reasons']['reason'];

                if($reason->save()){

                    $list = CHtml::listData(Reasons::model()->findAll(array('order'=>'reason')),'id','reason');

                    foreach($list as $key =>$value){
                        $options.=CHtml::tag('option', array('value'=>$key),CHtml::encode($value),true);
                    }
                    $res=array('ok'=>true,'message'=>$options);
                }
            }

            echo CJSON::encode($res);
            Yii::app()->end();
        }
    }

    public function actionZone(){

        $res=array('ok'=>false);
        $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);

        if(Yii::app()->request->isPostRequest){

            if(!empty($_POST['Zones'])){

                $zone=new Zones;
                $zone->zone=$_POST['Zones']['zone'];
                $zone->save();

                if($zone){

                    $list = CHtml::listData(Zones::model()->findAll(array('order'=>'zone')),'id','zone');

                    foreach($list as $key =>$value){
                        $options.=CHtml::tag('option', array('value'=>$key),CHtml::encode($value),true);
                    }
                    $res=array('ok'=>true,'message'=>$options);
                }
            }

            echo CJSON::encode($res);
            Yii::app()->end();
        }
    }


    public function actionDepartment(){

        $res=array('ok'=>false);
        $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);

        if(Yii::app()->request->isPostRequest){

            if(!empty($_POST['Departments'])){

                $department=new Departments;

                $department->department=$_POST['Departments']['department'];
                $department->save();

                if($department){

                    $list = CHtml::listData(Departments::model()->findAll(array('order'=>'department')),'id','department');

                    foreach($list as $key =>$value){
                        $options.=CHtml::tag('option', array('value'=>$key),CHtml::encode($value),true);
                    }
                    $res=array('ok'=>true,'message'=>$options);
                }

            }

            echo CJSON::encode($res);
            Yii::app()->end();
        }
    }

    public function actionHistory(){
        $model=new Tasks('history');
        $model->unsetAttributes();

        if(isset($_GET['Tasks'])){
            $model->attributes=$_GET['Tasks'];
        }

        $this->render('history',array(
            'model'=>$model,
        ));
    }

    public function changePriority(CEvent $event){

        $taskId=$event->sender;

        $task=Tasks::model()->findByPk($taskId->id);

        $days= (strtotime($task->date_due)-strtotime(date("Y-m-d")))/86400;
        $days= abs($days);
        $days = floor($days);

        if($days<=3) $task->priority=1;
        $task->save();

    }

    public function actionReallocate($id){

        $model=Tasks::model()->findByPk($id);

        $tracinganterior=TracingTask::model()->findAll(
            array(
                'condition'=>'task_id=:taskId',
                'params'=>array('taskId'=>$model->id)
            )
        );

        if(!empty($_POST['Tasks']['employee_id'])){
            $task=new Tasks;
            $task->name=$model->name;
            $task->description=$model->description;
            $task->date_due=$model->date_due;
            $task->date_entered=$model->date_entered;
            $task->status=4;
            $task->department=$model->department;
            $task->created_by=Yii::app()->user->id;
            $task->priority=$model->priority;
            $task->providers=$model->providers;
            $task->zone=$model->zone;

            if($_POST['Tasks']['isgroup']==1){
                $task->isgroup=1;
                $task->group_assigned_id=$_POST['Tasks']['group_assigned_id'];
            }

            if($_POST['Tasks']['isgroup']==0){
                $task->isgroup=0;
                $task->employee_id=$_POST['Tasks']['employee_id'];
            }

            $task->parent_id=$id;

            $model->isclose=1;

            if( $task->save() && $model->save()){

                foreach($tracinganterior as $item){

                    $tracing=new TracingTask;
                    $tracing->attributes=$item->attributes;
                    $tracing->task_id=$task->id;
                    $tracing->save();
                }

                $tracing=new TracingTask;
                $tracing->task_id=$task->id;
                $tracing->user_id=Yii::app()->user->id;
                $date_entered=date("Y-M-d H:i");
                $tracing->tracing_date=Yii::app()->quoteUtil->toSpanishDateTime1($date_entered);
                $tracing->comment=Yii::t('mx','Reassigned');

                $dateDue=new DateTime($model->date_due);
                $currentDate=new DateTime(date('Y-m-d H:i'));

                if(strtotime($model->date_due) > strtotime(date('Y-m-d H:i'))){
                    $dif=date_diff($dateDue,$currentDate);

                    $dias=$dif->d;
                    $horas=$dif->h;
                    $minutos=$dif->i;

                    $dias.=" ".Yii::t('mx','Days');
                    $horas.=" ".Yii::t('mx','Hours');
                    $minutos.=" ".Yii::t('mx','Minuts');

                    $tracing->task_expiration=$dias.', '.$horas.', '.$minutos;
                }

                $tracing->save();


                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('mytasks'));
            }

        }

        $this->render('reallocate',array(
            'model'=>$model,
        ));
    }

    public function actionEditStatus(){

        $r = Yii::app()->getRequest();

        if($r->getParam('editable')){
            Yii::app()->end();
        }

        $value=$r->getParam('value');
        $taskId=$r->getParam('pk');

        if($value==1){
            $task=Tasks::model()->findByPk($taskId);
            $task->status=1;
            $task->isclose=1;
            $task->date_finish=date('Y-m-d');
            $task->save();
        }
        else{
            $task=Tasks::model()->findByPk($taskId);
            $task->status=$value;
            $task->save();
        }

    }

    public function actionMyTasks(){

        $model=new Tasks('mytasks');
        $model->unsetAttributes();

        if(isset($_GET['Tasks'])){
            $model->attributes=$_GET['Tasks'];
        }


        $this->render('mytasks',array(
            'model'=>$model,
        ));

    }

    public function actionAccept(){
        $res=array('ok'=>true);
        $url= Yii::app()->user->isSuperAdmin ? Yii::app()->createUrl('/tasks') : Yii::app()->createUrl('/tasks/myTasks');
        $lista=array();

        if(Yii::app()->request->isPostRequest){

            if(!empty($_POST['id'])){
                $taskdId=$_POST['id'];
                $lista=explode(',',$taskdId);

                foreach($lista as $id){
                    $tasks=Tasks::model()->findByPk($id);

                    if($tasks->isgroup==0){
                        $tasks->accepted_by=Yii::app()->user->id;
                    }

                    if($tasks->isgroup==1){
                        if($tasks->accepted_users==''){
                            $tasks->accepted_users=Yii::app()->user->id;
                        }
                        else{
                            $aux=$tasks->accepted_users;
                            $tasks->accepted_users=Yii::app()->user->id.','.$aux;
                        }

                    }

                    $tasks->status=5;
                    $tasks->date_start=date('y-m-d H:i');
                    $tasks->save();
                    unset($tasks);
                }

                $res=array('ok'=>true,'redirect'=>$url);
            }else{
                $res=array('ok'=>false,'message'=>Yii::t('mx','Please, select items or items'));
            }

            echo CJSON::encode($res);
            Yii::app()->end();
        }
    }

    public function actionClose($id){

        $res=array('ok'=>false);

        if(Yii::app()->request->isPostRequest){
            $taskdId=$id;

            $tasks=Tasks::model()->findByPk($taskdId);
            $tasks->isclose=1;

            if($tasks->save()){
                $res=array('ok'=>true);
            }
        }

        echo CJSON::encode($res);
        Yii::app()->end();

    }

	public function actionView($id)
	{
        $model=$this->loadModel($id);

        $tracing=TracingTask::model()->findAll(array(
            'condition'=>'task_id=:taskId',
            'params'=>array('taskId'=>$model->id)
        ));

        $comments=new CArrayDataProvider($tracing);

        Yii::app()->quoteUtil->cronjob();

        if($model->status==1){

            //duration
            $days= (strtotime($model->date_start)-strtotime($model->date_finish))/86400;
            $days= abs($days);
            $model->duration= floor($days);

            //dias despues de fecha de vencimiento

            if($model->date_finish > $model->date_due){

                $vencimiento=(strtotime($model->date_finish)-strtotime($model->date_due))/86400;
                $vencimiento=abs($vencimiento);
                $model->days_after_date_due=$vencimiento;
            }

        }

		$this->render('view',array(
			'model'=>$model,
            'comments'=>$comments
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::import('bootstrap.widgets.TbForm');

		$model=new Tasks;
        $dep=new Departments;
        $zon=new Zones;

        $department = TbForm::createForm($dep->getForm(),$dep,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

        $zones= TbForm::createForm($zon->getForm(),$zon,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

		if(isset($_POST['Tasks']))
		{
			$model->attributes=$_POST['Tasks'];

            $date_entered=date("Y-M-d H:i");
            $model->date_entered=Yii::app()->quoteUtil->toSpanishDateTime1($date_entered);

            $model->date_due=$model->date_due." 17:00";
            $model->created_by=Yii::app()->user->id;
            $model->status=4;

            if(!empty($_POST['Tasks']['providers'])){
                $providers=implode(',',$_POST['Tasks']['providers']);
                $model->providers=$providers;
            }

            if($model->department!=null){
                $usedDepartment=Departments::model()->findByPk($model->department);
                $usedDepartment->used=$usedDepartment->used+1;
                $usedDepartment->save();
            }

            if($model->zone!=null){
                $usedZone=Zones::model()->findByPk($model->zone);
                $usedZone->used=$usedZone->used+1;
                $usedZone->save();
            }


			if($model->save()){

                $tracing=new TracingTask;
                $tracing->task_id=$model->id;
                $tracing->user_id=Yii::app()->user->id;
                $tracing->tracing_date=Yii::app()->quoteUtil->toSpanishDateTime1($date_entered);
                $tracing->comment=Yii::t('mx','First Entry');

                $dateDue=new DateTime($model->date_due);
                $currentDate=new DateTime(date('Y-m-d H:i'));

                if(strtotime($model->date_due) > strtotime(date('Y-m-d H:i'))){
                    $dif=date_diff($dateDue,$currentDate);

                    $dias=$dif->d;
                    $horas=$dif->h;
                    $minutos=$dif->i;

                    $dias.=" ".Yii::t('mx','Days');
                    $horas.=" ".Yii::t('mx','Hours');
                    $minutos.=" ".Yii::t('mx','Minuts');

                    $tracing->task_expiration=$dias.', '.$horas.', '.$minutos;
                }

                $tracing->save();


                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }

		}

		$this->render('create',array(
			'model'=>$model,
            'department'=>$department,
            'zones'=>$zones
		));
	}


	public function actionUpdate($id)
	{
        Yii::import('bootstrap.widgets.TbForm');
		$model=$this->loadModel($id);
        $dep=new Departments;
        $zon=new Zones;

        $department = TbForm::createForm($dep->getForm(),$dep,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

        $zones= TbForm::createForm($zon->getForm(),$zon,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tasks']))
		{
			$model->attributes=$_POST['Tasks'];
            $model->date_due=$model->date_due." 17:00";

            if(!empty($_POST['Tasks']['providers'])){
                $providers=implode(',',$_POST['Tasks']['providers']);
                $model->providers=$providers;
            }



			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }

		}

		$this->render('update',array(
			'model'=>$model,
            'department'=>$department,
            'zones'=>$zones
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

        Yii::app()->quoteUtil->cronjob();

        $model=new Tasks('search');
        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['Tasks']))
        $model->attributes=$_GET['Tasks'];

        $this->render('index',array(
        'model'=>$model,
        ));

	}

	/**
	 * Manages all models.
	 */

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Tasks::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tasks-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
