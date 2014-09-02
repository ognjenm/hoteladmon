<?php

class SeasonsController extends Controller
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
				'actions'=>array('admin','delete','index','view','create','update','calendar'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionCalendar()
    {

        $startYear=date('Y');
        $startYear=$startYear."-01-01";
        $endYear=date('Y');
        $endYear=$endYear."-12-31";
        $inicio=strtotime($startYear);
        $fin=strtotime($endYear);

        $sql="truncate calendar_season";
        $connection=Yii::app()->db;
        $command=$connection->createCommand($sql);
        $result=$command->execute();


        $sqlInsert="INSERT INTO calendar_season (dai,monthh) values";


        for($i=$inicio; $i<=$fin; $i+=86400):

            $fecha=date("Y-m-d",$i);

            $day=date("d", strtotime($fecha));
            $month=date("m", strtotime($fecha));

            if($i< $fin) $sqlInsert.="(".$day.",".$month."),";

            if($i==$fin) $sqlInsert.="(".$day.",".$month.");";


        endfor;

        $connection=Yii::app()->db;
        $command=$connection->createCommand($sqlInsert);
        $result=$command->execute();


        $conmemoration=Seasons::model()->findAll();

        foreach($conmemoration as $cm):

            $ini=strtotime($cm->froom);
            $fin=strtotime($cm->too);

            for($x=$ini;$x<$fin+86400;$x+=86400):

                $f=date("Y-m-d",$x);
                $day=date("d", strtotime($f));
                $month=date("m", strtotime($f));

                CalendarSeason::model()->updateAll(array('tipe'=>'ALTA'),'dai=:dai and monthh=:month',array('dai'=>$day,'month'=>$month));
            endfor;

        endforeach;


        Yii::app()->user->setFlash('success','Success.');
        $this->redirect(array('index'));
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Seasons;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Seasons']))
		{
			$model->attributes=$_POST['Seasons'];

			if($model->save())

                Yii::app()->user->setFlash('success','Success. please, update the schedule to apply to the rates');

				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Seasons']))
		{
			$model->attributes=$_POST['Seasons'];
			if($model->save())
                Yii::app()->user->setFlash('success','Success');
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new Seasons('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Seasons']))
        $model->attributes=$_GET['Seasons'];

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
		$model=Seasons::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='seasons-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
